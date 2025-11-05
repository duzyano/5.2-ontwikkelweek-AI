<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&L Tripwise - Jouw slimme reispartner</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.98);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            font-size: 1.8em;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-menu a:hover {
            color: #667eea;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s ease;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: #333;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 30px 50px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-50px, 50px) rotate(180deg); }
        }

        .hero-content {
            max-width: 1200px;
            text-align: center;
            color: white;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 4em;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.5em;
            margin-bottom: 40px;
            opacity: 0.95;
            animation: fadeInUp 1s ease-out 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.4s backwards;
        }

        .btn {
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: white;
            color: #667eea;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.3);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 2em;
            animation: bounce 2s infinite;
            cursor: pointer;
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        /* Features Section */
        .features {
            padding: 100px 30px;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2em;
            color: #666;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.2);
        }

        .feature-icon {
            font-size: 3.5em;
            margin-bottom: 20px;
        }

        .feature-title {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: #333;
        }

        .feature-description {
            color: #666;
            line-height: 1.6;
        }

        /* Planner Section */
        .planner {
            padding: 100px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .planner-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .planner-card {
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 0.95em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3em;
            z-index: 1;
        }

        input[type="text"], input[type="datetime-local"], select {
            width: 100%;
            padding: 18px 18px 18px 55px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            font-size: 1em;
            transition: all 0.3s ease;
            outline: none;
            background: white;
        }

        input[type="text"]:focus, input[type="datetime-local"]:focus, select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        select {
            cursor: pointer;
            appearance: none;
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat right 18px center;
            background-size: 12px;
        }

        .swap-btn {
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            background: #667eea;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.3em;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .swap-btn:hover {
            transform: translateY(-50%) rotate(180deg);
            background: #764ba2;
        }

        .search-btn {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .quick-links {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .quick-link {
            background: #f0f0f0;
            color: #667eea;
            padding: 10px 18px;
            border-radius: 25px;
            font-size: 0.9em;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            border: 2px solid transparent;
        }

        .quick-link:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Results Section */
        .results {
            padding: 40px 0;
            display: none;
        }

        .result-card {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .travel-time {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
        }

        .duration {
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.95em;
            font-weight: 600;
        }

        .route-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #666;
        }

        .route-steps {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .transport-icon {
            background: #fff;
            padding: 10px 15px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .transport-icon.train { 
            background: linear-gradient(135deg, #ffd93d 0%, #ffb800 100%);
            color: #333; 
        }
        .transport-icon.bus { 
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white; 
        }
        .transport-icon.tram { 
            background: linear-gradient(135deg, #4ecdc4 0%, #44a39f 100%);
            color: white; 
        }
        .transport-icon.metro { 
            background: linear-gradient(135deg, #95e1d3 0%, #7cc9bf 100%);
            color: #333; 
        }

        .arrow {
            color: #999;
            font-size: 1.2em;
        }

        .loading {
            text-align: center;
            padding: 50px;
            display: none;
        }

        .spinner {
            border: 4px solid rgba(102, 126, 234, 0.2);
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Statistics Section */
        .stats {
            padding: 100px 30px;
            background: white;
        }

        .stats-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-item {
            padding: 30px;
        }

        .stat-number {
            font-size: 3.5em;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.2em;
            color: #666;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 60px 30px 30px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            margin-bottom: 20px;
            font-size: 1.3em;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero-title {
                font-size: 2.5em;
            }

            .hero-subtitle {
                font-size: 1.2em;
            }

            .planner-card {
                padding: 25px;
            }

            .swap-btn {
                right: 10px;
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">D&L Tripwise</div>
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Functies</a></li>
                <li><a href="#planner">Plan reis</a></li>
                <li><a href="#stats">Over ons</a></li>
            </ul>
            <button class="mobile-menu-btn">☰</button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1 class="hero-title">D&L Tripwise</h1>
            <p class="hero-subtitle">Jouw slimme reispartner door heel Nederland</p>
            <div class="hero-buttons">
                <a href="#planner" class="btn btn-primary">Plan je reis nu</a>
                <a href="#features" class="btn btn-secondary">Ontdek meer</a>
            </div>
        </div>
        <div class="scroll-indicator" onclick="document.getElementById('features').scrollIntoView({behavior: 'smooth'})">
            ↓
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2 class="section-title">Waarom D&L Tripwise?</h2>
        <p class="section-subtitle">Alles wat je nodig hebt voor een zorgeloze reis</p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚆</div>
                <h3 class="feature-title">Alle vervoersmiddelen</h3>
                <p class="feature-description">Trein, bus, tram, metro en meer. Vind altijd de beste route.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3 class="feature-title">Real-time updates</h3>
                <p class="feature-description">Live vertragingen en wijzigingen, zodat je altijd op de hoogte bent.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3 class="feature-title">Slimme routeplanner</h3>
                <p class="feature-description">Onze AI vindt de snelste en goedkoopste route voor jou.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3 class="feature-title">Digitaal reizen</h3>
                <p class="feature-description">Koop en beheer je tickets direct in de app.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <h3 class="feature-title">Slimme notificaties</h3>
                <p class="feature-description">Krijg meldingen over je reis en mis nooit meer je trein.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🌍</div>
                <h3 class="feature-title">Heel Nederland</h3>
                <p class="feature-description">Van Amsterdam tot Maastricht, overal actuele reisinformatie.</p>
            </div>
        </div>
    </section>

    <!-- Planner Section -->
    <section class="planner" id="planner">
        <h2 class="section-title" style="color: white; margin-bottom: 50px;">Plan je reis</h2>
        
        <div class="planner-container">
            <div class="planner-card">
                <form id="searchForm">
                    <div class="input-group" style="position: relative;">
                        <label for="from">Vertrek</label>
                        <div class="input-wrapper">
                            <span class="input-icon">📍</span>
                            <input type="text" id="from" placeholder="bijv. Amsterdam Centraal" required>
                        </div>
                        <button type="button" class="swap-btn" onclick="swapLocations()">⇅</button>
                    </div>

                    <div class="input-group">
                        <label for="to">Bestemming</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🎯</span>
                            <input type="text" id="to" placeholder="bijv. Rotterdam Centraal" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="datetime">Datum & Tijd</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🕐</span>
                            <input type="datetime-local" id="datetime" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="travelType">Reistype</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🚆</span>
                            <select id="travelType">
                                <option value="departure">Vertrek om dit tijdstip</option>
                                <option value="arrival">Aankomst om dit tijdstip</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="search-btn">🔍 Zoek reisadvies</button>

                    <div class="quick-links">
                        <span class="quick-link" onclick="fillQuick('Amsterdam Centraal', 'Rotterdam Centraal')">AMS → RTM</span>
                        <span class="quick-link" onclick="fillQuick('Utrecht Centraal', 'Den Haag Centraal')">UTR → DHG</span>
                        <span class="quick-link" onclick="fillQuick('Eindhoven Centraal', 'Maastricht')">EHV → MST</span>
                        <span class="quick-link" onclick="fillQuick('Groningen', 'Amsterdam Centraal')">GRN → AMS</span>
                    </div>
                </form>

                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <div style="color: #667eea; font-weight: 600;">Reisadviezen zoeken...</div>
                </div>

                <div class="results" id="results"></div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats" id="stats">
        <h2 class="section-title">D&L Tripwise in cijfers</h2>
        <p class="section-subtitle">Vertrouwd door duizenden reizigers</p>
        
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">500K+</div>
                <div class="stat-label">Actieve gebruikers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">2M+</div>
                <div class="stat-label">Geplande reizen</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">98%</div>
                <div class="stat-label">Klanttevredenheid</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Beschikbaar</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>D&L Tripwise</h3>
                <p>Jouw betrouwbare partner voor openbaar vervoer in Nederland.</p>
            </div>
            <div class="footer-section">
                <h3>Services</h3>
                <ul>
                    <li><a href="#">Reisplanner</a></li>
                    <li><a href="#">Live updates</a></li>
                    <li><a href="#">Tickets kopen</a></li>
                    <li><a href="#">Mijn reizen</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Informatie</h3>
                <ul>
                    <li><a href="#">Over ons</a></li>
                    <li><a href="#">Veelgestelde vragen</a></li>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Algemene voorwaarden</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li><a href="#">Klantenservice</a></li>
                    <li><a href="#">E-mail</a></li>
                    <li><a href="#">Partnerships</a></li>
                    <li><a href="#">Pers</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 D&L Tripwise. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Set default datetime to now
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        document.getElementById('datetime').value = now.toISOString().slice(0, 16);

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        function swapLocations() {
            const from = document.getElementById('from');
            const to = document.getElementById('to');
            const temp = from.value;
            from.value = to.value;
            to.value = temp;
        }

        function fillQuick(from, to) {
            document.getElementById('from').value = from;
            document.getElementById('to').value = to;
            document.getElementById('searchForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            searchJourney();
        });

        function searchJourney() {
            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;

            // Show loading
            document.getElementById('loading').style.display = 'block';
            document.getElementById('results').style.display = 'none';

            // Simulate API call
            setTimeout(() => {
                displayResults(from, to);
            }, 1800);
        }

        function displayResults(from, to) {
            document.getElementById('loading').style.display = 'none';
            
            const resultsDiv = document.getElementById('results');
            resultsDiv.style.display = 'block';

            // Generate mock results
            const mockResults = generateMockResults(from, to);
            
            resultsDiv.innerHTML = mockResults }

            </script>