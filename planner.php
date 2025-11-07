<?php include 'includes/header.php'; ?>

<section class="planner-hero">
    <div class="hero-content">
        <h1>✈️ Plan je Reis</h1>
        <p>Vind de beste route door heel Nederland</p>
    </div>
</section>

<section class="planner-wrapper">
    <div class="planner-container">
        <!-- Main Planner Card -->
        <div class="planner-card">
            <div class="card-header">
                <h2>🚆 Reisplanner</h2>
                <p>Vul je gegevens in en ontdek de beste reisopties</p>
            </div>

            <form id="reisForm" class="planner-form">
                <!-- Vertrekpunt -->
                <div class="form-group">
                    <label for="start">
                        <span class="label-icon">📍</span>
                        Vertrekpunt
                    </label>
                    <div class="autocomplete-wrapper">
                        <input type="text" id="start" name="start" placeholder="Bijv. Amsterdam Centraal" autocomplete="off" required>
                        <div id="start-suggestions" class="autocomplete-suggestions"></div>
                    </div>
                </div>

                <!-- Swap Button -->
                <div class="swap-container">
                    <button type="button" class="swap-btn" id="swapBtn" title="Wissel van/naar">
                        <span>⇅</span>
                    </button>
                </div>

                <!-- Bestemming -->
                <div class="form-group">
                    <label for="bestemming">
                        <span class="label-icon">🎯</span>
                        Bestemming
                    </label>
                    <div class="autocomplete-wrapper">
                        <input type="text" id="bestemming" name="bestemming" placeholder="Bijv. Utrecht Centraal" autocomplete="off" required>
                        <div id="bestemming-suggestions" class="autocomplete-suggestions"></div>
                    </div>
                </div>

                <!-- Datum & Tijd Grid -->
                <div class="datetime-grid">
                    <div class="form-group">
                        <label for="dag">
                            <span class="label-icon">📅</span>
                            Vertrekdag
                        </label>
                        <select id="dag" required>
                            <option value="">Kies een dag</option>
                        </select>
                    </div>

                    <div class="form-group time-group">
                        <label>
                            <span class="label-icon">🕐</span>
                            Vertrektijd
                        </label>
                        <div class="tijd-selects">
                            <select id="uur" required>
                                <option value="">Uur</option>
                            </select>
                            <select id="minuut" required>
                                <option value="">Min</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Reistype -->
                <div class="form-group">
                    <label for="reistype">
                        <span class="label-icon">🚆</span>
                        Reistype
                    </label>
                    <select id="reistype">
                        <option value="departure">Vertrek om dit tijdstip</option>
                        <option value="arrival">Aankomst om dit tijdstip</option>
                    </select>
                </div>

                <!-- Quick Action Buttons -->
                <div class="quick-actions">
                    <button type="button" id="vandaagBtn" class="quick-btn">
                        <span>📅</span> Vandaag + huidige tijd
                    </button>
                    <button type="button" id="nuBtn" class="quick-btn primary">
                        <span>⚡</span> Vertrek nu
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn">
                    <span>🔍</span> Zoek reisadvies
                </button>
            </form>

            <!-- Quick Routes -->
            <div class="quick-routes">
                <h3>🚀 Populaire routes</h3>
                <div class="route-chips">
                    <button class="route-chip" data-from="Amsterdam Centraal" data-to="Rotterdam Centraal">
                        AMS → RTM
                    </button>
                    <button class="route-chip" data-from="Utrecht Centraal" data-to="Den Haag Centraal">
                        UTR → DHG
                    </button>
                    <button class="route-chip" data-from="Eindhoven Centraal" data-to="Maastricht">
                        EHV → MST
                    </button>
                    <button class="route-chip" data-from="Groningen" data-to="Amsterdam Centraal">
                        GRN → AMS
                    </button>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div id="resultaat" class="resultaat"></div>

        <!-- Loading State -->
        <div id="loading" class="loading" style="display: none;">
            <div class="spinner"></div>
            <p>Reismogelijkheden zoeken...</p>
        </div>

        <!-- Tips Section -->
        <div class="tips-section">
            <div class="tip-card">
                <span class="tip-icon">💡</span>
                <h4>Tip</h4>
                <p>Boek je reis in de daluren voor de beste prijzen!</p>
            </div>
            <div class="tip-card">
                <span class="tip-icon">⚡</span>
                <h4>Snelheid</h4>
                <p>Direct reizen is vaak sneller dan overstappen</p>
            </div>
            <div class="tip-card">
                <span class="tip-icon">💰</span>
                <h4>Bespaar</h4>
                <p>Vergelijk altijd meerdere reisopties</p>
            </div>
        </div>
    </div>
</section>

<style>
/* CSS Variables - Werkt met dark/light mode */
body {
    --planner-bg-primary: #f8f9fa;
    --planner-bg-secondary: #ffffff;
    --planner-text-primary: #333333;
    --planner-text-secondary: #666666;
    --planner-accent-primary: #667eea;
    --planner-accent-secondary: #764ba2;
    --planner-border-color: #e0e0e0;
    --planner-shadow-sm: 0 4px 15px rgba(0,0,0,0.08);
    --planner-shadow-md: 0 8px 25px rgba(0,0,0,0.12);
    --planner-shadow-lg: 0 12px 40px rgba(0,0,0,0.15);
    --planner-input-bg: #ffffff;
}

body.light-mode {
    --planner-bg-primary: #f8f9fa;
    --planner-bg-secondary: #ffffff;
    --planner-text-primary: #333333;
    --planner-text-secondary: #666666;
    --planner-accent-primary: #667eea;
    --planner-accent-secondary: #764ba2;
    --planner-border-color: #e0e0e0;
    --planner-shadow-sm: 0 4px 15px rgba(0,0,0,0.08);
    --planner-shadow-md: 0 8px 25px rgba(0,0,0,0.12);
    --planner-shadow-lg: 0 12px 40px rgba(102,126,234,0.2);
    --planner-input-bg: #ffffff;
}

body:not(.light-mode) {
    --planner-bg-primary: #0a0a0a;
    --planner-bg-secondary: #1a1a1a;
    --planner-text-primary: #D4AF37;
    --planner-text-secondary: #B8960F;
    --planner-accent-primary: #D4AF37;
    --planner-accent-secondary: #FFD700;
    --planner-border-color: rgba(212, 175, 55, 0.3);
    --planner-shadow-sm: 0 4px 15px rgba(212, 175, 55, 0.1);
    --planner-shadow-md: 0 8px 25px rgba(212, 175, 55, 0.15);
    --planner-shadow-lg: 0 12px 40px rgba(212, 175, 55, 0.2);
    --planner-input-bg: #000000;
}

/* Hero Section */
.planner-hero {
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    padding: 120px 30px 80px;
    text-align: center;
    margin-top: 70px;
    position: relative;
    overflow: hidden;
}

body:not(.light-mode) .planner-hero {
    background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #000000 100%);
}

.planner-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: float 20s infinite ease-in-out;
}

body:not(.light-mode) .planner-hero::before {
    background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
}

.planner-hero::after {
    content: '';
    position: absolute;
    bottom: -50%;
    left: -50%;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
    animation: float 25s infinite ease-in-out reverse;
}

body:not(.light-mode) .planner-hero::after {
    background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-50px, 50px) rotate(180deg); }
}

.planner-hero .hero-content {
    position: relative;
    z-index: 1;
}

.planner-hero h1 {
    font-size: 3em;
    color: white;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

body:not(.light-mode) .planner-hero h1 {
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 50%, #D4AF37 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.planner-hero p {
    font-size: 1.3em;
    color: rgba(255,255,255,0.95);
}

body:not(.light-mode) .planner-hero p {
    color: #B8960F;
}

/* Main Wrapper */
.planner-wrapper {
    background: var(--planner-bg-primary);
    min-height: calc(100vh - 250px);
    padding: 50px 30px;
}

.planner-container {
    max-width: 700px;
    margin: -60px auto 0;
    position: relative;
    z-index: 10;
}

/* Planner Card */
.planner-card {
    background: var(--planner-bg-secondary);
    border-radius: 25px;
    padding: 40px;
    box-shadow: var(--planner-shadow-lg);
    border: 1px solid var(--planner-border-color);
    margin-bottom: 30px;
}

.card-header {
    text-align: center;
    margin-bottom: 35px;
}

.card-header h2 {
    font-size: 2.2em;
    color: var(--planner-text-primary);
    margin-bottom: 10px;
}

.card-header p {
    color: var(--planner-text-secondary);
    font-size: 1.05em;
}

/* Form Groups */
.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    color: var(--planner-text-primary);
    font-weight: 600;
    font-size: 0.95em;
}

.label-icon {
    font-size: 1.2em;
}

.autocomplete-wrapper {
    position: relative;
}

input[type="text"],
select {
    width: 100%;
    padding: 16px 20px;
    border-radius: 12px;
    border: 2px solid var(--planner-border-color);
    background: var(--planner-input-bg);
    color: var(--planner-text-primary);
    font-size: 1em;
    transition: all 0.3s ease;
    font-family: inherit;
}

input[type="text"]:focus,
select:focus {
    outline: none;
    border-color: var(--planner-accent-primary);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

body:not(.light-mode) input[type="text"]:focus,
body:not(.light-mode) select:focus {
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
}

input::placeholder {
    color: var(--planner-text-secondary);
    opacity: 0.6;
}

select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 18px center;
    background-size: 12px;
    padding-right: 45px;
}

body:not(.light-mode) select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23D4AF37' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
}

select option {
    background: var(--planner-bg-secondary);
    color: var(--planner-text-primary);
}

/* Swap Button */
.swap-container {
    display: flex;
    justify-content: center;
    margin: -10px 0;
    position: relative;
    z-index: 5;
}

.swap-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: white;
    font-size: 1.5em;
    cursor: pointer;
    box-shadow: var(--planner-shadow-md);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

body:not(.light-mode) .swap-btn {
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
    color: #000;
}

.swap-btn:hover {
    transform: rotate(180deg) scale(1.1);
    box-shadow: var(--planner-shadow-lg);
}

/* DateTime Grid */
.datetime-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.tijd-selects {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

/* Autocomplete */
.autocomplete-suggestions {
    position: absolute;
    background: var(--planner-bg-secondary);
    border: 2px solid var(--planner-border-color);
    border-top: none;
    border-radius: 0 0 12px 12px;
    max-height: 250px;
    overflow-y: auto;
    z-index: 999;
    width: 100%;
    top: 100%;
    left: 0;
    box-shadow: var(--planner-shadow-md);
    display: none;
}

.autocomplete-suggestions.active {
    display: block;
}

.autocomplete-suggestions div {
    padding: 12px 20px;
    cursor: pointer;
    color: var(--planner-text-primary);
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--planner-border-color);
}

.autocomplete-suggestions div:last-child {
    border-bottom: none;
}

.autocomplete-suggestions div:hover,
.autocomplete-suggestions div.active {
    background: rgba(102, 126, 234, 0.1);
    color: var(--planner-accent-primary);
}

body:not(.light-mode) .autocomplete-suggestions div:hover,
body:not(.light-mode) .autocomplete-suggestions div.active {
    background: rgba(212, 175, 55, 0.2);
}

.autocomplete-suggestions::-webkit-scrollbar {
    width: 8px;
}

.autocomplete-suggestions::-webkit-scrollbar-track {
    background: var(--planner-bg-primary);
}

.autocomplete-suggestions::-webkit-scrollbar-thumb {
    background: var(--planner-accent-primary);
    border-radius: 4px;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 20px;
}

.quick-btn {
    padding: 14px 20px;
    border: 2px solid var(--planner-border-color);
    border-radius: 12px;
    background: var(--planner-bg-primary);
    color: var(--planner-text-primary);
    font-size: 0.95em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.quick-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--planner-shadow-sm);
    border-color: var(--planner-accent-primary);
}

.quick-btn.primary {
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: white;
    border-color: transparent;
}

body:not(.light-mode) .quick-btn.primary {
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
    color: #000;
}

/* Submit Button */
.submit-btn {
    width: 100%;
    padding: 18px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: white;
    font-size: 1.15em;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--planner-shadow-md);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

body:not(.light-mode) .submit-btn {
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
    color: #000;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--planner-shadow-lg);
}

/* Quick Routes */
.quick-routes {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid var(--planner-border-color);
}

.quick-routes h3 {
    font-size: 1.2em;
    color: var(--planner-text-primary);
    margin-bottom: 15px;
    text-align: center;
}

.route-chips {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.route-chip {
    padding: 10px 20px;
    border-radius: 25px;
    border: 2px solid var(--planner-border-color);
    background: var(--planner-bg-primary);
    color: var(--planner-text-primary);
    font-size: 0.9em;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.route-chip:hover {
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
}

body:not(.light-mode) .route-chip:hover {
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
    color: #000;
}

/* Results */
.resultaat {
    background: var(--planner-bg-secondary);
    border-radius: 20px;
    padding: 30px;
    box-shadow: var(--planner-shadow-md);
    border: 1px solid var(--planner-border-color);
    margin-bottom: 30px;
    display: none;
}

.resultaat.show {
    display: block;
    animation: slideUp 0.5s ease-out;
}

.resultaat h3 {
    color: var(--planner-text-primary);
    font-size: 1.5em;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.resultaat p {
    color: var(--planner-text-secondary);
    margin-bottom: 12px;
    font-size: 1.05em;
    line-height: 1.6;
}

.resultaat strong {
    color: var(--planner-text-primary);
}

.result-item {
    background: var(--planner-bg-primary);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    border: 1px solid var(--planner-border-color);
    transition: all 0.3s ease;
    cursor: pointer;
}

.result-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--planner-shadow-sm);
}

/* Loading */
.loading {
    text-align: center;
    padding: 50px;
    background: var(--planner-bg-secondary);
    border-radius: 20px;
    box-shadow: var(--planner-shadow-md);
    border: 1px solid var(--planner-border-color);
}

.spinner {
    border: 4px solid var(--planner-border-color);
    border-top: 4px solid var(--planner-accent-primary);
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

.loading p {
    color: var(--planner-text-primary);
    font-weight: 600;
    font-size: 1.1em;
}

/* Tips Section */
.tips-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.tip-card {
    background: var(--planner-bg-secondary);
    padding: 25px 20px;
    border-radius: 15px;
    border: 1px solid var(--planner-border-color);
    box-shadow: var(--planner-shadow-sm);
    text-align: center;
    transition: all 0.3s ease;
}

.tip-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--planner-shadow-md);
}

.tip-icon {
    font-size: 2.5em;
    display: block;
    margin-bottom: 12px;
}

.tip-card h4 {
    color: var(--planner-accent-primary);
    font-size: 1.2em;
    margin-bottom: 8px;
}

.tip-card p {
    color: var(--planner-text-secondary);
    font-size: 0.95em;
    line-height: 1.5;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .planner-hero {
        padding: 100px 20px 60px;
    }
    
    .planner-hero h1 {
        font-size: 2em;
    }
    
    .planner-card {
        padding: 25px 20px;
    }
    
    .datetime-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .tips-section {
        grid-template-columns: 1fr;
    }
}
.info-btn {
    display: inline-block;
    margin-top: 10px;
    background: linear-gradient(135deg, var(--planner-accent-primary) 0%, var(--planner-accent-secondary) 100%);
    color: white;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

body:not(.light-mode) .info-btn {
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
    color: #000;
}

.info-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--planner-shadow-sm);
}

</style>

<script>
// --- Nederlandse stations lijst (70+ stations) ---
const stations = [
    "Amsterdam Centraal", "Amsterdam Amstel", "Amsterdam Sloterdijk", "Amsterdam Zuid", "Amsterdam Bijlmer Arena",
    "Rotterdam Centraal", "Rotterdam Alexander", "Rotterdam Blaak", "Rotterdam Lombardijen",
    "Den Haag Centraal", "Den Haag HS", "Den Haag Laan van NOI", "Den Haag Mariahoeve",
    "Utrecht Centraal", "Utrecht Overvecht", "Utrecht Lunetten", "Utrecht Vaartsche Rijn",
    "Eindhoven Centraal", "Eindhoven Strijp-S", "Eindhoven Airport",
    "Groningen", "Groningen Europapark", "Groningen Noord",
    "Maastricht", "Maastricht Randwyck",
    "Arnhem Centraal", "Arnhem Velperpoort", "Arnhem Presikhaaf", "Arnhem Zuid",
    "Nijmegen", "Nijmegen Heyendaal", "Nijmegen Lent", "Nijmegen Goffert",
    "Haarlem", "Haarlem Spaarnwoude",
    "Leiden Centraal", "Leiden Lammenschans",
    "Tilburg", "Tilburg Universiteit", "Tilburg Reeshof",
    "Breda", "Breda Prinsenbeek",
    "Almere Centrum", "Almere Buiten", "Almere Oostvaarders", "Almere Parkwijk", "Almere Muziekwijk", "Almere Poort",
    "Apeldoorn", "Apeldoorn De Maten", "Apeldoorn Osseveld",
    "Enschede", "Enschede Drienerlo", "Enschede Kennispark",
    "Zwolle", "Zwolle Stadshagen",
    "Amersfoort Centraal", "Amersfoort Schothorst", "Amersfoort Vathorst",
    "Delft", "Delft Campus", "Delft Zuid",
    "Schiphol Airport",
    "Dordrecht", "Dordrecht Zuid", "Dordrecht Stadspolders",
    "Leeuwarden", "Leeuwarden Camminghaburen",
    "Deventer", "Deventer Colmschate",
    "Venlo",
    "Helmond", "Helmond Brouwhuis", "Helmond 't Hout",
    "Alkmaar", "Alkmaar Noord",
    "Zaandam", "Zaandam Kogerveld",
    "Gouda", "Gouda Goverwelle",
    "Ede-Wageningen",
    "Hilversum", "Hilversum Media Park", "Hilversum Sportpark",
    "Lelystad Centrum",
    "Roosendaal",
    "Vlissingen",
    "Zutphen",
    "Hengelo", "Hengelo Gezondheidspark",
    "Alphen aan den Rijn", "Alphen aan den Rijn Centrum",
    "Hoorn", "Hoorn Kersenboogerd",
    "Purmerend", "Purmerend Weidevenne", "Purmerend Overwhere",
    "Zaanstad",
    "Schagen",
    "Houten", "Houten Castellum",
    "Veenendaal Centrum", "Veenendaal West",
    "Hoofddorp",
    "Beverwijk",
    "Zeist",
    "Harderwijk",
    "Sittard"
];

// --- Verbeterde Autocomplete met keyboard navigatie ---
function setupAutocomplete(input, suggestionsContainer) {
    let currentFocus = -1;
    let filteredStations = [];

    input.addEventListener('input', function() {
        const val = this.value.toLowerCase();
        suggestionssuggestionsContainer.innerHTML = '';
        currentFocus = -1;
        
        if (!val) {
            suggestionsContainer.classList.remove('active');
            return;
        }

        // Filter stations die de tekst bevatten
        filteredStations = stations.filter(s => s.toLowerCase().includes(val));
        
        if (filteredStations.length === 0) {
            suggestionsContainer.classList.remove('active');
            return;
        }

        // Toon max 10 resultaten
        filteredStations.slice(0, 10).forEach((station, index) => {
            const div = document.createElement('div');
            div.textContent = station;
            div.dataset.index = index;
            
            div.addEventListener('click', function() {
                input.value = station;
                suggestionsContainer.innerHTML = '';
                suggestionsContainer.classList.remove('active');
            });
            
            suggestionsContainer.appendChild(div);
        });
        
        suggestionsContainer.classList.add('active');
    });

    // Keyboard navigatie
    input.addEventListener('keydown', function(e) {
        const items = suggestionsContainer.getElementsByTagName('div');
        
        if (e.keyCode === 40) { // Arrow Down
            e.preventDefault();
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            addActive(items);
        } else if (e.keyCode === 38) { // Arrow Up
            e.preventDefault();
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            addActive(items);
        } else if (e.keyCode === 13) { // Enter
            e.preventDefault();
            if (currentFocus > -1 && items[currentFocus]) {
                items[currentFocus].click();
            }
        } else if (e.keyCode === 27) { // Escape
            suggestionsContainer.innerHTML = '';
            suggestionsContainer.classList.remove('active');
        }
    });

    function addActive(items) {
        if (!items) return false;
        removeActive(items);
        if (currentFocus >= items.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = items.length - 1;
        items[currentFocus].classList.add('active');
        items[currentFocus].scrollIntoView({ block: 'nearest' });
    }

    function removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('active');
        }
    }

    // Sluit suggesties bij klikken buiten het veld
    document.addEventListener('click', function(e) {
        if (e.target !== input) {
            suggestionsContainer.innerHTML = '';
            suggestionsContainer.classList.remove('active');
        }
    });
}

// --- Vul dagen dropdown ---
const dagSelect = document.getElementById('dag');
function vulDagen() {
    dagSelect.innerHTML = '<option value="">Kies een dag</option>';
    for(let i=0; i<14; i++){
        const dt = new Date();
        dt.setDate(dt.getDate()+i);
        const dagTekst = dt.toLocaleDateString('nl-NL',{ weekday:'long', day:'numeric', month:'long' });
        const dagValue = dt.toISOString().split('T')[0];
        const option = document.createElement('option');
        option.value = dagValue;
        option.textContent = dagTekst;
        dagSelect.appendChild(option);
    }
}

// --- Vul uren dropdown ---
const uurSelect = document.getElementById('uur');
function vulUren(currentHour=null){
    uurSelect.innerHTML = '<option value="">Uur</option>';
    for(let u=0; u<24; u++){
        if(currentHour!==null && u<currentHour) continue;
        const option = document.createElement('option');
        option.value = u;
        option.textContent = u.toString().padStart(2,'0');
        uurSelect.appendChild(option);
    }
}

// --- Vul minuten dropdown 0,5,10,...55 ---
const minuutSelect = document.getElementById('minuut');
function vulMinuten(currentMinute=null){
    minuutSelect.innerHTML = '<option value="">Min</option>';
    for(let m=0; m<60; m+=5){
        if(currentMinute!==null && m<currentMinute) continue;
        const option = document.createElement('option');
        option.value = m;
        option.textContent = m.toString().padStart(2,'0');
        minuutSelect.appendChild(option);
    }
}

// --- Swap button functionaliteit ---
document.getElementById('swapBtn').addEventListener('click', function() {
    const startInput = document.getElementById('start');
    const bestemmingInput = document.getElementById('bestemming');
    
    const temp = startInput.value;
    startInput.value = bestemmingInput.value;
    bestemmingInput.value = temp;
    
    // Animatie effect
    this.style.transform = 'rotate(180deg) scale(1.1)';
    setTimeout(() => {
        this.style.transform = '';
    }, 300);
});

// --- Vandaag knop ---
document.getElementById('vandaagBtn').addEventListener('click', ()=>{
    const nu = new Date();
    const todayISO = nu.toISOString().split('T')[0];
    dagSelect.value = todayISO;
    vulUren(nu.getHours());
    let minuut = Math.round(nu.getMinutes()/5)*5;
    if(minuut===60) minuut=55;
    vulMinuten(minuut);
    uurSelect.value = nu.getHours();
    minuutSelect.value = minuut;
});

// --- Vertrek nu knop ---
document.getElementById('nuBtn').addEventListener('click', ()=>{
    document.getElementById('vandaagBtn').click();
    setTimeout(() => {
        document.getElementById('reisForm').dispatchEvent(new Event('submit'));
    }, 100);
});

// --- Update tijd dropdowns bij dag keuze ---
dagSelect.addEventListener('change', function(){
    const gekozenDag = new Date(this.value);
    const nu = new Date();
    if(gekozenDag.toDateString() === nu.toDateString()){
        vulUren(nu.getHours());
        let minuut = Math.round(nu.getMinutes()/5)*5;
        if(minuut===60) minuut=55;
        vulMinuten(minuut);
    } else {
        vulUren();
        vulMinuten();
    }
});

// --- Quick route chips ---
document.querySelectorAll('.route-chip').forEach(chip => {
    chip.addEventListener('click', function() {
        const from = this.dataset.from;
        const to = this.dataset.to;
        document.getElementById('start').value = from;
        document.getElementById('bestemming').value = to;
        
        // Scroll naar form
        document.getElementById('reisForm').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        
        // Visual feedback
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 200);
    });
});

// --- Initialiseer alles ---
vulDagen();
vulUren();
vulMinuten();

// Setup autocomplete voor beide velden
setupAutocomplete(document.getElementById('start'), document.getElementById('start-suggestions'));
setupAutocomplete(document.getElementById('bestemming'), document.getElementById('bestemming-suggestions'));

// --- Form submit + Mock resultaten ---
document.getElementById('reisForm').addEventListener('submit', async function(e){
    e.preventDefault();
    
    const start = document.getElementById('start').value;
    const bestemming = document.getElementById('bestemming').value;
    const dagISO = dagSelect.value;
    const uur = document.getElementById('uur').value;
    const minuut = document.getElementById('minuut').value;
    const reistype = document.getElementById('reistype').value;

    if(!start || !bestemming || !dagISO || !uur || !minuut){
        alert("⚠️ Vul alle velden in!");
        return;
    }

    const dt = new Date(dagISO);
    dt.setHours(uur, minuut);

    const dag = dt.toLocaleDateString('nl-NL',{ weekday:'long', day:'numeric', month:'long' });
    const tijd = dt.toLocaleTimeString('nl-NL',{ hour:'2-digit', minute:'2-digit' });

    // Toon loading
    const resultaatDiv = document.getElementById('resultaat');
    const loadingDiv = document.getElementById('loading');
    
    resultaatDiv.style.display = 'none';
    loadingDiv.style.display = 'block';
    
    // Scroll naar loading
    loadingDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Simuleer API call
    setTimeout(() => {
        loadingDiv.style.display = 'none';
        
        resultaatDiv.innerHTML = `
            <h3>📅 Reisoverzicht</h3>
            <p><strong>🚉 Vertrek:</strong> ${start}</p>
            <p><strong>🎯 Bestemming:</strong> ${bestemming}</p>
            <p><strong>📆 Datum & tijd:</strong> ${dag}, ${tijd}</p>
            <p><strong>⚙️ Type:</strong> ${reistype === 'departure' ? 'Vertrek' : 'Aankomst'} om dit tijdstip</p>
            
            <h3 style="margin-top: 25px;">🚆 Reismogelijkheden</h3>
            ${generateMockResults(start, bestemming, dt)}
        `;
        
        resultaatDiv.style.display = 'block';
        resultaatDiv.classList.add('show');
        resultaatDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 1500);

    // Probeer realtime API (optioneel)
    try{
        const timeStr = `${uur.toString().padStart(2,'0')}:${minuut.toString().padStart(2,'0')}`;
        const res = await fetch(`api/realtime.php?from=${encodeURIComponent(start)}&to=${encodeURIComponent(bestemming)}&time=${timeStr}`);
        
        if(res.ok) {
            const data = await res.json();
            if(!data.error && data.legs) {
                let html = `<h3 style="margin-top: 25px;">🚆 Live Reisinformatie</h3>`;
                data.legs.forEach(leg => {
                    html += `
                        <div class="result-item">
                            <p><strong>${leg.type.toUpperCase()} ${leg.line}</strong></p>
                            <p>Van ${leg.from} (${leg.departure}) naar ${leg.to} (${leg.arrival})</p>
                            <p>Status: ${leg.status}</p>
                        </div>
                    `;
                });
                resultaatDiv.innerHTML += html;
            }
        }
    } catch(err) {
        console.log('API niet beschikbaar, toon mock data');
    }
});

// --- Genereer mock resultaten ---
function generateMockResults(from, to, datetime) {
    const transportTypes = [
        { type: 'Intercity', icon: '🚆', color: '#FFD700' },
        { type: 'Sprinter', icon: '🚊', color: '#4ecdc4' },
        { type: 'Bus', icon: '🚌', color: '#ff6b6b' }
    ];
    
    let html = '';
    
    for(let i = 0; i < 3; i++) {
        const transport = transportTypes[i % transportTypes.length];
        const departureTime = new Date(datetime.getTime() + (i * 20 * 60000));
        const duration = 45 + (i * 10);
        const arrivalTime = new Date(departureTime.getTime() + (duration * 60000));
        
        const depTime = departureTime.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
        const arrTime = arrivalTime.toLocaleTimeString('nl-NL', { hour: '2-digit', minute: '2-digit' });
        
        const query = new URLSearchParams({
            from: from,
            to: to,
            departure: depTime,
            arrival: arrTime,
            duration: duration,
            type: transport.type,
        }).toString();

        html += `
            <div class="result-item">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <div>
                        <strong style="font-size: 1.2em;">${depTime} - ${arrTime}</strong>
                    </div>
                    <div style="background: var(--planner-accent-primary); color: white; padding: 5px 15px; border-radius: 20px; font-weight: 600; font-size: 0.9em;">
                        ${duration} min
                    </div>
                </div>
                <p style="margin-bottom: 8px;">
                    <span style="font-size: 1.2em;">${transport.icon}</span>
                    <strong>${transport.type}</strong> - ${i === 0 ? 'Direct' : i + ' overstap' + (i > 1 ? 'pen' : '')}
                </p>
                <p style="color: var(--planner-text-secondary); font-size: 0.95em;">
                    Via: ${from} → ${to}
                </p>
                <p style="color: #4CAF50; font-size: 0.9em; margin-top: 8px;">
                    ✓ Op tijd
                </p>
                <a href="plannerinfo.php?${query}" class="info-btn">ℹ️ Meer informatie</a>
            </div>
        `;
    }
    
    return html;
}


// --- Smooth scroll voor alle interne links ---
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

console.log('✅ D&L Tripwise Planner geladen - Alle functies actief!');
</script>

<?php include 'includes/footer.php'; ?>