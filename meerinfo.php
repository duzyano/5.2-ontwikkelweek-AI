<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reisplanner Informatie - D&L Tripwise</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: #000;
            color: #D4AF37;
        }

        /* Navigation - Same as index.php */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(212, 175, 55, 0.3);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
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
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 50%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: pointer;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: #D4AF37;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-menu a:hover {
            color: #FFD700;
        }

        .theme-toggle {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Main Content */
        .content-wrapper {
            padding-top: 100px;
            min-height: 100vh;
        }

        .info-hero {
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            padding: 80px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .info-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        }

        .info-hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .info-title {
            font-size: 3em;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .info-subtitle {
            font-size: 1.3em;
            color: #B8960F;
            line-height: 1.6;
        }

        /* Info Sections */
        .info-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 30px;
        }

        .info-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
        }

        .info-section:hover {
            border-color: rgba(255, 215, 0, 0.4);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.2);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
        }

        .section-icon {
            font-size: 2.5em;
            filter: grayscale(0.2) brightness(1.2);
        }

        .section-title {
            font-size: 2em;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-content {
            color: #999;
            line-height: 1.8;
            font-size: 1.1em;
        }

        .section-content p {
            margin-bottom: 15px;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .feature-item {
            background: rgba(212, 175, 55, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(212, 175, 55, 0.1);
            border-color: rgba(255, 215, 0, 0.3);
            transform: translateY(-5px);
        }

        .feature-item-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .feature-item-title {
            font-size: 1.2em;
            color: #D4AF37;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-item-desc {
            color: #888;
            font-size: 0.95em;
            line-height: 1.6;
        }

        .step-list {
            counter-reset: step-counter;
            list-style: none;
            margin-top: 20px;
        }

        .step-item {
            position: relative;
            padding-left: 80px;
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }

        .step-item:last-child {
            border-bottom: none;
        }

        .step-item::before {
            counter-increment: step-counter;
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 0;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .step-title {
            font-size: 1.3em;
            color: #D4AF37;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .step-desc {
            color: #999;
            line-height: 1.7;
        }

        .tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .tip-card {
            background: rgba(212, 175, 55, 0.08);
            border-left: 4px solid #D4AF37;
            padding: 20px;
            border-radius: 10px;
        }

        .tip-icon {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .tip-text {
            color: #999;
            font-size: 0.95em;
            line-height: 1.6;
        }

        .cta-section {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            border-radius: 20px;
            padding: 50px;
            text-align: center;
            margin-top: 40px;
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.4);
        }

        .cta-title {
            color: #000;
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .cta-text {
            color: #1a1a1a;
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .cta-button {
            background: #000;
            color: #D4AF37;
            padding: 18px 45px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2em;
            display: inline-block;
            transition: all 0.3s ease;
            border: 2px solid #000;
        }

        .cta-button:hover {
            background: transparent;
            color: #000;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Footer - Same as index.php */
        .footer {
            background: #0a0a0a;
            color: #888;
            padding: 60px 30px 30px;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
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
            color: #D4AF37;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section a {
            color: #888;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #D4AF37;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(212, 175, 55, 0.1);
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .info-title {
                font-size: 2em;
            }

            .info-subtitle {
                font-size: 1.1em;
            }

            .info-section {
                padding: 25px;
            }

            .section-title {
                font-size: 1.5em;
            }

            .feature-list {
                grid-template-columns: 1fr;
            }

            .step-item {
                padding-left: 70px;
            }

            .cta-section {
                padding: 30px 20px;
            }

            .cta-title {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo" onclick="window.location.href='index.php'">D&L Tripwise</div>
            <ul class="nav-menu">
                <li><button class="theme-toggle" onclick="toggleTheme()">☀️ Light Mode</button></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="features.php">Functies</a></li>
                <li><a href="planner.php">Plan reis</a></li>
                <li><a href="about.php">Over ons</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Hero Section -->
        <section class="info-hero">
            <div class="info-hero-content">
                <h1 class="info-title">Hoe werkt de reisplanner?</h1>
                <p class="info-subtitle">Ontdek alle mogelijkheden van onze geavanceerde reisplanner en plan je perfecte reis door Nederland</p>
            </div>
        </section>

        <!-- Info Container -->
        <div class="info-container">
            <!-- Overzicht Section -->
            <div class="info-section">
                <div class="section-header">
                    <span class="section-icon">🎯</span>
                    <h2 class="section-title">Wat kan de reisplanner?</h2>
                </div>
                <div class="section-content">
                    <p>De D&L Tripwise reisplanner is jouw persoonlijke assistent voor het plannen van reizen door heel Nederland. Met realtime gegevens van alle vervoerders vind je altijd de beste route naar jouw bestemming.</p>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-item-icon">🚆</div>
                            <div class="feature-item-title">Multimodaal reizen</div>
                            <div class="feature-item-desc">Combineer trein, bus, tram, metro en zelfs lopen voor de beste route</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">⚡</div>
                            <div class="feature-item-title">Realtime informatie</div>
                            <div class="feature-item-desc">Live vertragingen, storingen en platformwijzigingen direct in je reisadvies</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">💰</div>
                            <div class="feature-item-title">Prijsinformatie</div>
                            <div class="feature-item-desc">Zie direct de reiskosten en vergelijk verschillende opties</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">🔄</div>
                            <div class="feature-item-title">Alternatieve routes</div>
                            <div class="feature-item-desc">Meerdere routeopties zodat je altijd kunt kiezen wat het beste past</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stappen Section -->
            <div class="info-section">
                <div class="section-header">
                    <span class="section-icon">📋</span>
                    <h2 class="section-title">Plan je reis in 4 stappen</h2>
                </div>
                <div class="section-content">
                    <ol class="step-list">
                        <li class="step-item">
                            <div class="step-title">Voer je vertrek- en aankomstpunt in</div>
                            <div class="step-desc">Type de naam van je vertrekstation of -halte en bestemming. Onze intelligente zoekfunctie herkent automatisch stations, haltes en adressen door heel Nederland.</div>
                        </li>
                        <li class="step-item">
                            <div class="step-title">Kies datum en tijd</div>
                            <div class="step-desc">Selecteer wanneer je wilt vertrekken of aankomen. Je kunt kiezen tussen 'Vertrek om dit tijdstip' of 'Aankomst om dit tijdstip' om precies te plannen wanneer je onderweg bent.</div>
                        </li>
                        <li class="step-item">
                            <div class="step-title">Bekijk je reisadvies</div>
                            <div class="step-desc">Onze planner toont meerdere routeopties met complete informatie: reistijd, overstappen, vervoersmiddelen, prijzen en actuele vertrek- en aankomsttijden.</div>
                        </li>
                        <li class="step-item">
                            <div class="step-title">Kies je favoriete route</div>
                            <div class="step-desc">Vergelijk de routes en selecteer de optie die het beste bij je past. Sla je reis op of koop direct een ticket via onze app.</div>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- Features Section -->
            <div class="info-section">
                <div class="section-header">
                    <span class="section-icon">✨</span>
                    <h2 class="section-title">Slimme functies</h2>
                </div>
                <div class="section-content">
                    <p>Ontdek de geavanceerde functies die jouw reiservaring nog beter maken:</p>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <div class="feature-item-icon">🔔</div>
                            <div class="feature-item-title">Vertraagmeldingen</div>
                            <div class="feature-item-desc">Ontvang push-notificaties bij vertragingen of wijzigingen in je reis</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">⭐</div>
                            <div class="feature-item-title">Favoriete routes</div>
                            <div class="feature-item-desc">Sla je meest gebruikte routes op voor snelle toegang</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">📍</div>
                            <div class="feature-item-title">Locatiedeling</div>
                            <div class="feature-item-desc">Deel je reis met vrienden en familie zodat ze kunnen meekijken</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">🎫</div>
                            <div class="feature-item-title">Direct tickets kopen</div>
                            <div class="feature-item-desc">Koop je trein-, bus- of tramkaartje direct in de app</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">🌐</div>
                            <div class="feature-item-title">Offline beschikbaar</div>
                            <div class="feature-item-desc">Download routes voor offline gebruik tijdens je reis</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-item-icon">♿</div>
                            <div class="feature-item-title">Toegankelijkheid</div>
                            <div class="feature-item-desc">Filter op toegankelijke routes met liften en hellingen</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="info-section">
                <div class="section-header">
                    <span class="section-icon">💡</span>
                    <h2 class="section-title">Handige tips</h2>
                </div>
                <div class="section-content">
                    <div class="tips-grid">
                        <div class="tip-card">
                            <div class="tip-icon">⏰</div>
                            <div class="tip-text"><strong>Plan ruim op tijd</strong> - Bij belangrijke afspraken adviseren we om minstens één route eerder te vertrekken voor extra zekerheid.</div>
                        </div>
                        <div class="tip-card">
                            <div class="tip-icon">🔄</div>
                            <div class="tip-text"><strong>Check live updates</strong> - Ververs je reisadvies kort voor vertrek om de meest actuele informatie te zien.</div>
                        </div>
                        <div class="tip-card">
                            <div class="tip-icon">💳</div>
                            <div class="tip-text"><strong>OV-chipkaart geldig</strong> - Controleer voor vertrek of je voldoende saldo hebt op je OV-chipkaart.</div>
                        </div>
                        <div class="tip-card">
                            <div class="tip-icon">📱</div>
                            <div class="tip-text"><strong>Download de app</strong> - Met onze mobiele app heb je altijd je reisadvies bij de hand, ook zonder internet.</div>
                        </div>
                        <div class="tip-card">
                            <div class="tip-icon">🎒</div>
                            <div class="tip-text"><strong>Drukke tijden</strong> - Vermijd spitsuren (7:00-9:00 en 17:00-19:00) voor een comfortabelere reis.</div>
                        </div>
                        <div class="tip-card">
                            <div class="tip-icon">🗺️</div>
                            <div class="tip-text"><strong>Ken je route</strong> - Bekijk vooraf het perron of de halte waar je moet overstappen om verwarring te voorkomen.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="cta-section">
                <h2 class="cta-title">Klaar om te reizen?</h2>
                <p class="cta-text">Begin nu met het plannen van je perfecte reis door Nederland</p>
                <a href="planner.php" class="cta-button">🚀 Start Reisplanner</a>
            </div>
        </div>
    </div>

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
                    <li><a href="planner.php">Reisplanner</a></li>
                    <li><a href="live-updates.php">Live updates</a></li>
                    <li><a href="tickets.php">Tickets kopen</a></li>
                    <li><a href="my-trips.php">Mijn reizen</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Informatie</h3>
                <ul>
                    <li><a href="about.php">Over ons</a></li>
                    <li><a href="faq.php">Veelgestelde vragen</a></li>
                    <li><a href="privacy.php">Privacy</a></li>
                    <li><a href="terms.php">Algemene voorwaarden</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <ul>
                    <li><a href="support.php">Klantenservice</a></li>
                    <li><a href="mailto:info@dltripwise.nl">E-mail</a></li>
                    <li><a href="partnerships.php">Partnerships</a></li>
                    <li><a href="press.php">Pers</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 D&L Tripwise. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script>
        function toggleTheme() {
            // Theme toggle functionaliteit kan hier toegevoegd worden
            const button = document.querySelector('.theme-toggle');
            if (button.textContent.includes('Light')) {
                button.textContent = '🌙 Dark Mode';
                // Voeg light mode classes toe
            } else {
                button.textContent = '☀️ Light Mode';
                // Verwijder light mode classes
            }
        }
    </script>
</body>
</html>