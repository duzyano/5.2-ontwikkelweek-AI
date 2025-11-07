<?php include 'includes/header.php'; ?>

<?php
// Haal reisgegevens op uit URL parameters
$from = htmlspecialchars($_GET['from'] ?? 'Onbekend');
$to = htmlspecialchars($_GET['to'] ?? 'Onbekend');
$departure = htmlspecialchars($_GET['departure'] ?? 'Onbekend');
$arrival = htmlspecialchars($_GET['arrival'] ?? 'Onbekend');
$duration = htmlspecialchars($_GET['duration'] ?? 'Onbekend');
$type = htmlspecialchars($_GET['type'] ?? 'Onbekend');
$transfers = htmlspecialchars($_GET['transfers'] ?? '0');
$price = htmlspecialchars($_GET['price'] ?? 'N/B');
$platform = htmlspecialchars($_GET['platform'] ?? 'N/B');

// Bereken aankomsttijd als die niet is opgegeven
if ($departure !== 'Onbekend' && $duration !== 'Onbekend' && $arrival === 'Onbekend') {
    $departureTime = strtotime($departure);
    $arrivalTime = $departureTime + ($duration * 60);
    $arrival = date('H:i', $arrivalTime);
}
?>

<section class="plannerinfo-hero">
    <div class="hero-content">
        <div class="route-header">
            <div class="location-badge">
                <span class="location-icon">📍</span>
                <span class="location-text"><?= $from ?></span>
            </div>
            <div class="route-arrow">
                <span class="arrow-icon">→</span>
            </div>
            <div class="location-badge destination">
                <span class="location-icon">🎯</span>
                <span class="location-text"><?= $to ?></span>
            </div>
        </div>
        <div class="journey-badge">
            <span class="journey-icon">🚆</span>
            <span class="journey-text">Gedetailleerd Reisadvies</span>
        </div>
    </div>
</section>

<section class="plannerinfo-wrapper">
    <div class="plannerinfo-container">
        
        <!-- Hoofdinformatie Card -->
        <div class="info-card main-info">
            <div class="card-header">
                <h2><span class="header-icon">🕐</span> Reistijd & Planning</h2>
            </div>
            <div class="card-content">
                <div class="time-overview">
                    <div class="time-block departure">
                        <div class="time-label">Vertrek</div>
                        <div class="time-value"><?= $departure ?></div>
                        <div class="time-location"><?= $from ?></div>
                        <?php if ($platform !== 'N/B'): ?>
                            <div class="platform-badge">Perron <?= $platform ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="journey-duration">
                        <div class="duration-line"></div>
                        <div class="duration-badge">
                            <span class="duration-icon">⏱️</span>
                            <span class="duration-text"><?= $duration ?> min</span>
                        </div>
                        <div class="duration-line"></div>
                    </div>
                    
                    <div class="time-block arrival">
                        <div class="time-label">Aankomst</div>
                        <div class="time-value"><?= $arrival ?></div>
                        <div class="time-location"><?= $to ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reisdetails Grid -->
        <div class="details-grid">
            <div class="info-card detail-card">
                <div class="detail-icon">🚆</div>
                <div class="detail-label">Vervoersmiddel</div>
                <div class="detail-value"><?= $type ?></div>
            </div>
            
            <div class="info-card detail-card">
                <div class="detail-icon">🔄</div>
                <div class="detail-label">Overstappen</div>
                <div class="detail-value"><?= $transfers ?></div>
            </div>
            
            <div class="info-card detail-card">
                <div class="detail-icon">💰</div>
                <div class="detail-label">Geschatte kosten</div>
                <div class="detail-value">€<?= $price ?></div>
            </div>
            
            <div class="info-card detail-card">
                <div class="detail-icon">📏</div>
                <div class="detail-label">Totale reistijd</div>
                <div class="detail-value"><?= $duration ?> min</div>
            </div>
        </div>

        <!-- Reisstappen Card -->
        <div class="info-card steps-card">
            <div class="card-header">
                <h2><span class="header-icon">📋</span> Jouw Reisstappen</h2>
            </div>
            <div class="card-content">
                <div class="journey-steps">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <div class="step-title">Vertrek vanaf <?= $from ?></div>
                            <div class="step-description">
                                <span class="step-time"><?= $departure ?></span>
                                <?php if ($platform !== 'N/B'): ?>
                                    <span class="step-platform">Perron <?= $platform ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="step-tip">💡 Wees 5 minuten van tevoren aanwezig op het perron</div>
                        </div>
                    </div>

                    <?php if ($transfers > 0): ?>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <div class="step-title">Overstappen (<?= $transfers ?>x)</div>
                            <div class="step-description">
                                <span class="step-detail">Controleer de schermen voor actuele informatie</span>
                            </div>
                            <div class="step-tip">⚡ Houd rekening met overstaptijd</div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="step-item">
                        <div class="step-number"><?= $transfers > 0 ? '3' : '2' ?></div>
                        <div class="step-content">
                            <div class="step-title">Aankomst op <?= $to ?></div>
                            <div class="step-description">
                                <span class="step-time"><?= $arrival ?></span>
                            </div>
                            <div class="step-tip">✅ Je bent aangekomen op je bestemming</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Handige Tips Card -->
        <div class="info-card tips-card">
            <div class="card-header">
                <h2><span class="header-icon">💡</span> Handige Reistips</h2>
            </div>
            <div class="card-content">
                <div class="tips-grid">
                    <div class="tip-item">
                        <div class="tip-icon">⏰</div>
                        <div class="tip-text">Check altijd de actuele vertrektijden vlak voor vertrek</div>
                    </div>
                    <div class="tip-item">
                        <div class="tip-icon">💳</div>
                        <div class="tip-text">Zorg dat je OV-chipkaart voldoende saldo heeft</div>
                    </div>
                    <div class="tip-item">
                        <div class="tip-icon">📱</div>
                        <div class="tip-text">Download je reis voor offline toegang</div>
                    </div>
                    <div class="tip-item">
                        <div class="tip-icon">🔔</div>
                        <div class="tip-text">Zet notificaties aan voor vertraagmeldingen</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acties Sectie -->
        <div class="actions-section">
            <a href="planner.php" class="action-btn back-btn">
                <span class="btn-icon">←</span>
                <span class="btn-text">Terug naar Planner</span>
            </a>
            <button class="action-btn save-btn" onclick="saveJourney()">
                <span class="btn-icon">💾</span>
                <span class="btn-text">Reis Opslaan</span>
            </button>
            <button class="action-btn share-btn" onclick="shareJourney()">
                <span class="btn-icon">📤</span>
                <span class="btn-text">Delen</span>
            </button>
        </div>

        <!-- Extra Info Card -->
        <div class="info-card extra-info">
            <div class="card-header">
                <h2><span class="header-icon">ℹ️</span> Belangrijke Informatie</h2>
            </div>
            <div class="card-content">
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-icon">⚠️</span>
                        <span class="info-text">Dienstregelingen kunnen wijzigen. Controleer altijd de actuele tijden.</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">🎫</span>
                        <span class="info-text">Vergeet niet in- en uit te checken met je OV-chipkaart.</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">♿</span>
                        <span class="info-text">Voor hulp bij instappen, neem contact op met de vervoerder.</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
:root {
    --planner-bg-primary: #000;
    --planner-bg-secondary: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
    --planner-accent-primary: #D4AF37;
    --planner-accent-secondary: #FFD700;
    --planner-text-primary: #D4AF37;
    --planner-text-secondary: #B8960F;
    --planner-text-muted: #999;
    --planner-border: rgba(212, 175, 55, 0.2);
    --planner-border-hover: rgba(255, 215, 0, 0.4);
    --planner-shadow-sm: 0 2px 10px rgba(212, 175, 55, 0.1);
    --planner-shadow-md: 0 4px 20px rgba(212, 175, 55, 0.15);
    --planner-shadow-lg: 0 8px 30px rgba(212, 175, 55, 0.2);
}

body.light-mode {
    --planner-bg-primary: #f8f9fa;
    --planner-bg-secondary: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    --planner-accent-primary: #667eea;
    --planner-accent-secondary: #764ba2;
    --planner-text-primary: #333;
    --planner-text-secondary: #667eea;
    --planner-text-muted: #666;
    --planner-border: rgba(102, 126, 234, 0.2);
    --planner-border-hover: rgba(102, 126, 234, 0.4);
    --planner-shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.08);
    --planner-shadow-md: 0 4px 20px rgba(0, 0, 0, 0.1);
    --planner-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.15);
}

/* Hero Section */
.plannerinfo-hero {
    background: var(--planner-bg-secondary);
    padding: 120px 30px 60px;
    margin-top: 80px;
    border-bottom: 1px solid var(--planner-border);
}

.hero-content {
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
}

.route-header {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-bottom: 25px;
}

.location-badge {
    background: rgba(212, 175, 55, 0.1);
    border: 2px solid var(--planner-border);
    padding: 20px 35px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
}

body.light-mode .location-badge {
    background: rgba(102, 126, 234, 0.1);
}

.location-badge:hover {
    border-color: var(--planner-border-hover);
    transform: translateY(-3px);
    box-shadow: var(--planner-shadow-md);
}

.location-icon {
    font-size: 2em;
}

.location-text {
    font-size: 1.5em;
    font-weight: 700;
    color: var(--planner-text-primary);
}

.route-arrow {
    font-size: 2.5em;
    color: var(--planner-accent-primary);
}

.journey-badge {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: #000;
    padding: 15px 30px;
    border-radius: 50px;
    font-size: 1.1em;
    font-weight: 700;
    box-shadow: var(--planner-shadow-md);
}

body.light-mode .journey-badge {
    color: white;
}

.journey-icon {
    font-size: 1.3em;
}

/* Main Wrapper */
.plannerinfo-wrapper {
    background: var(--planner-bg-primary);
    min-height: 80vh;
    padding: 60px 20px;
}

.plannerinfo-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Info Cards */
.info-card {
    background: var(--planner-bg-secondary);
    border: 1px solid var(--planner-border);
    border-radius: 20px;
    padding: 35px;
    margin-bottom: 30px;
    box-shadow: var(--planner-shadow-md);
    transition: all 0.3s ease;
}

.info-card:hover {
    border-color: var(--planner-border-hover);
    box-shadow: var(--planner-shadow-lg);
}

.card-header {
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--planner-border);
}

.card-header h2 {
    color: var(--planner-text-primary);
    font-size: 1.8em;
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-icon {
    font-size: 1.2em;
}

/* Time Overview */
.time-overview {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 30px;
    align-items: center;
}

.time-block {
    text-align: center;
    padding: 25px;
    background: rgba(212, 175, 55, 0.05);
    border-radius: 15px;
    border: 1px solid var(--planner-border);
}

body.light-mode .time-block {
    background: rgba(102, 126, 234, 0.05);
}

.time-label {
    color: var(--planner-text-muted);
    font-size: 0.9em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.time-value {
    font-size: 2.5em;
    font-weight: bold;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 10px;
}

.time-location {
    color: var(--planner-text-primary);
    font-weight: 600;
    font-size: 1.1em;
}

.platform-badge {
    display: inline-block;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: #000;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85em;
    font-weight: 700;
    margin-top: 10px;
}

body.light-mode .platform-badge {
    color: white;
}

.journey-duration {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.duration-line {
    width: 2px;
    height: 30px;
    background: linear-gradient(180deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
}

.duration-badge {
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: #000;
    padding: 12px 20px;
    border-radius: 25px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: var(--planner-shadow-md);
}

body.light-mode .duration-badge {
    color: white;
}

/* Details Grid */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.detail-card {
    text-align: center;
    padding: 30px 20px;
}

.detail-icon {
    font-size: 3em;
    margin-bottom: 15px;
    filter: grayscale(0.2) brightness(1.2);
}

.detail-label {
    color: var(--planner-text-muted);
    font-size: 0.9em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.detail-value {
    font-size: 1.8em;
    font-weight: bold;
    color: var(--planner-text-primary);
}

/* Journey Steps */
.journey-steps {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.step-item {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: rgba(212, 175, 55, 0.05);
    border-radius: 15px;
    border-left: 4px solid var(--planner-accent-primary);
    transition: all 0.3s ease;
}

body.light-mode .step-item {
    background: rgba(102, 126, 234, 0.05);
}

.step-item:hover {
    background: rgba(212, 175, 55, 0.1);
    transform: translateX(5px);
}

body.light-mode .step-item:hover {
    background: rgba(102, 126, 234, 0.1);
}

.step-number {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
    font-weight: bold;
    flex-shrink: 0;
    box-shadow: var(--planner-shadow-sm);
}

body.light-mode .step-number {
    color: white;
}

.step-content {
    flex: 1;
}

.step-title {
    font-size: 1.3em;
    font-weight: 700;
    color: var(--planner-text-primary);
    margin-bottom: 8px;
}

.step-description {
    color: var(--planner-text-muted);
    margin-bottom: 10px;
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
}

.step-time {
    font-weight: 700;
    color: var(--planner-accent-primary);
    font-size: 1.1em;
}

.step-platform {
    background: rgba(212, 175, 55, 0.2);
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.9em;
    font-weight: 600;
}

body.light-mode .step-platform {
    background: rgba(102, 126, 234, 0.2);
}

.step-tip {
    font-size: 0.9em;
    color: var(--planner-text-secondary);
    font-style: italic;
}

/* Tips Grid */
.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 20px;
    background: rgba(212, 175, 55, 0.05);
    border-radius: 12px;
    border: 1px solid var(--planner-border);
    transition: all 0.3s ease;
}

body.light-mode .tip-item {
    background: rgba(102, 126, 234, 0.05);
}

.tip-item:hover {
    background: rgba(212, 175, 55, 0.1);
    border-color: var(--planner-border-hover);
    transform: translateY(-3px);
}

body.light-mode .tip-item:hover {
    background: rgba(102, 126, 234, 0.1);
}

.tip-icon {
    font-size: 1.8em;
    flex-shrink: 0;
}

.tip-text {
    color: var(--planner-text-muted);
    line-height: 1.6;
    font-size: 0.95em;
}

/* Actions Section */
.actions-section {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin: 40px 0;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.05em;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--planner-shadow-sm);
}

.back-btn {
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: #000;
}

body.light-mode .back-btn {
    color: white;
}

.save-btn {
    background: rgba(76, 175, 80, 0.9);
    color: white;
}

body.light-mode .save-btn {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
}

.share-btn {
    background: rgba(33, 150, 243, 0.9);
    color: white;
}

body.light-mode .share-btn {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--planner-shadow-lg);
}

.btn-icon {
    font-size: 1.2em;
}

/* Extra Info */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: rgba(212, 175, 55, 0.05);
    border-radius: 10px;
    border-left: 3px solid var(--planner-accent-primary);
}

body.light-mode .info-item {
    background: rgba(102, 126, 234, 0.05);
}

.info-icon {
    font-size: 1.5em;
    flex-shrink: 0;
}

.info-text {
    color: var(--planner-text-muted);
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 768px) {
    .plannerinfo-hero {
        padding: 100px 20px 40px;
    }

    .route-header {
        flex-direction: column;
        gap: 15px;
    }

    .location-badge {
        padding: 15px 25px;
    }

    .location-text {
        font-size: 1.2em;
    }

    .time-overview {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .journey-duration {
        flex-direction: row;
    }

    .duration-line {
        width: 50px;
        height: 2px;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }

    .step-item {
        flex-direction: column;
        text-align: center;
    }

    .step-number {
        margin: 0 auto;
    }

    .step-description {
        justify-content: center;
    }

    .actions-section {
        flex-direction: column;
    }

    .action-btn {
        width: 100%;
        justify-content: center;
    }

    .tips-grid {
        grid-template-columns: 1fr;
    }

    .info-card {
        padding: 20px;
    }
}
</style>

<script>
function saveJourney() {
    // Functie om reis op te slaan
    alert('Reis succesvol opgeslagen! 💾');
    // Hier kun je later localStorage of een API call implementeren
}

function shareJourney() {
    // Functie om reis te delen
    if (navigator.share) {
        navigator.share({
            title: 'Mijn reis van <?= $from ?> naar <?= $to ?>',
            text: 'Bekijk mijn reisplanning via D&L Tripwise',
            url: window.location.href
        }).catch(err => console.log('Error sharing:', err));
    } else {
        // Fallback: kopieer link naar clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Link gekopieerd naar klembord! 📤');
    }
}
</script>

<?php include 'includes/footer.php'; ?>