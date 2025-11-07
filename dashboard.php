<?php
session_start();
require_once 'includes/db_config.php';
require_once 'includes/auth_functions.php';
require_once 'includes/trip_functions.php';

// Check login
requireLogin();

$user = getCurrentUser();
$isAdmin = isAdmin();

// Haal recente reizen op
$recentTrips = getUserTrips($user['id'], null, 5);

// Haal favoriete routes op
$favoriteRoutes = getFavoriteRoutes($user['id']);

// Welkom bericht bij eerste login
$showWelcome = isset($_GET['welcome']) && $_GET['welcome'] == 1;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - D&L Tripwise</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #0a0a0a;
            color: #D4AF37;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.95);
            padding: 20px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            font-size: 1.8em;
            font-weight: bold;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: pointer;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: #FFD700;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        .welcome-banner {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-text p {
            color: #888;
            font-size: 1.1em;
        }

        .quick-actions {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgba(212, 175, 55, 0.3);
            color: #D4AF37;
        }

        .btn-secondary:hover {
            border-color: #D4AF37;
            background: rgba(212, 175, 55, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 15px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 215, 0, 0.5);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.2);
        }

        .stat-icon {
            font-size: 2.5em;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 2.5em;
            font-weight: bold;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #888;
            font-size: 1em;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .section-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            padding: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h2 {
            font-size: 1.8em;
            color: #D4AF37;
        }

        .section-header a {
            color: #888;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .section-header a:hover {
            color: #D4AF37;
        }

        .trip-item {
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .trip-item:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateX(5px);
        }

        .trip-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .trip-route {
            font-size: 1.2em;
            font-weight: 600;
            color: #D4AF37;
        }

        .trip-date {
            color: #888;
            font-size: 0.9em;
        }

        .trip-details {
            color: #888;
            font-size: 0.95em;
            line-height: 1.6;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state-icon {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: #888;
            margin-bottom: 10px;
        }

        .favorite-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.1);
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .favorite-item:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .favorite-route {
            font-weight: 600;
            color: #D4AF37;
        }

        .favorite-count {
            color: #888;
            font-size: 0.85em;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #4caf50;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .admin-badge {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .welcome-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            .quick-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo" onclick="window.location.href='index.php'">D&L Tripwise</div>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="planner.php">Plan Reis</a>
                <a href="my-trips.php">Mijn Reizen</a>
                <?php if ($isAdmin): ?>
                    <a href="admin/index.php">Admin Panel</a>
                <?php endif; ?>
                <a href="profile.php">Profiel</a>
                <a href="logout.php" style="color: #ff6b6b;">Uitloggen</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        <?php if ($showWelcome): ?>
            <div class="alert-success">
                <span style="font-size: 2em;">🎉</span>
                <div>
                    <strong>Welkom bij D&L Tripwise!</strong><br>
                    Je account is succesvol aangemaakt. Begin nu met het plannen van je eerste reis!
                </div>
            </div>
        <?php endif; ?>

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>
                    Welkom terug, <?php echo htmlspecialchars($user['first_name'] ?: $user['username']); ?>!
                    <?php if ($isAdmin): ?>
                        <span class="admin-badge">ADMIN</span>
                    <?php endif; ?>
                </h1>
                <p>Klaar voor je volgende reis? Plan nu je reis of bekijk je geplande reizen.</p>
            </div>
            <div class="quick-actions">
                <a href="planner.php" class="btn btn-primary">
                    <span>🚆</span> Plan Nieuwe Reis
                </a>
                <a href="my-trips.php" class="btn btn-secondary">
                    <span>📋</span> Mijn Reizen
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🚆</div>
                <div class="stat-value"><?php echo count($recentTrips); ?></div>
                <div class="stat-label">Geplande Reizen</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-value"><?php echo count($favoriteRoutes); ?></div>
                <div class="stat-label">Favoriete Routes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🎫</div>
                <div class="stat-value">0</div>
                <div class="stat-label">Actieve Tickets</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value"><?php 
                    $days = round((time() - strtotime($user['created_at'])) / 86400);
                    echo $days;
                ?></div>
                <div class="stat-label">Dagen Lid</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Trips -->
            <div class="section-card">
                <div class="section-header">
                    <h2>📅 Recente Reizen</h2>
                    <a href="my-trips.php">Bekijk alle →</a>
                </div>

                <?php if (empty($recentTrips)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">🚆</div>
                        <h3>Nog geen reizen gepland</h3>
                        <p>Begin nu met het plannen van je eerste reis!</p>
                        <br>
                        <a href="planner.php" class="btn btn-primary">Plan je eerste reis</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($recentTrips as $trip): ?>
                        <div class="trip-item" onclick="window.location.href='trip-details.php?id=<?php echo $trip['id']; ?>'">
                            <div class="trip-header">
                                <div class="trip-route">
                                    <?php echo htmlspecialchars($trip['from_station_name']); ?> 
                                    → 
                                    <?php echo htmlspecialchars($trip['to_station_name']); ?>
                                </div>
                                <div class="trip-date">
                                    <?php echo date('d M Y', strtotime($trip['departure_date'])); ?>
                                </div>
                            </div>
                            <div class="trip-details">
                                🕐 Vertrek: <?php echo date('H:i', strtotime($trip['departure_time'])); ?>
                                <?php if ($trip['duration_minutes']): ?>
                                    • ⏱️ <?php echo $trip['duration_minutes']; ?> min
                                <?php endif; ?>
                                <?php if ($trip['number_of_transfers']): ?>
                                    • 🔄 <?php echo $trip['number_of_transfers']; ?> overstap<?php echo $trip['number_of_transfers'] > 1 ? 'pen' : ''; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Favorite Routes -->
            <div class="section-card">
                <div class="section-header">
                    <h2>⭐ Favorieten</h2>
                    <a href="favorites.php">Beheer →</a>
                </div>

                <?php if (empty($favoriteRoutes)): ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">⭐</div>
                        <h3>Geen favorieten</h3>
                        <p style="font-size: 0.9em;">Voeg je meest gebruikte routes toe als favoriet.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($favoriteRoutes as $route): ?>
                        <div class="favorite-item" onclick="fillPlannerFromFavorite('<?php echo htmlspecialchars($route['from_station_name']); ?>', '<?php echo htmlspecialchars($route['to_station_name']); ?>')">
                            <div>
                                <div class="favorite-route">
                                    <?php echo htmlspecialchars($route['from_station_name']); ?> 
                                    → 
                                    <?php echo htmlspecialchars($route['to_station_name']); ?>
                                </div>
                                <div class="favorite-count">
                                    Gebruikt: <?php echo $route['usage_count']; ?>x
                                </div>
                            </div>
                            <span style="font-size: 1.5em;">→</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function fillPlannerFromFavorite(from, to) {
            localStorage.setItem('planner_from', from);
            localStorage.setItem('planner_to', to);
            window.location.href = 'planner.php';
        }
    </script>
</body>
</html>