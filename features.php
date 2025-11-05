<?php include 'includes/header.php'; ?>

<main class="features-page">
    <section class="features-hero">
        <h1 class="features-title">🚀 Handige Features</h1>
        <p class="features-subtitle">Alles wat je nodig hebt om slim, snel en zorgeloos te reizen.</p>
    </section>

    <section class="features-list">
        <div class="feature-card">
            <div class="feature-icon">🗺️</div>
            <h3>Slimme routeplanning</h3>
            <p>Ontvang de meest efficiënte routes met real-time updates voor trein, bus, tram en metro.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🏨</div>
            <h3>Hotel- en activiteitensuggesties</h3>
            <p>Krijg persoonlijke aanbevelingen voor verblijf en bezienswaardigheden langs je route.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🌦️</div>
            <h3>Weersvoorspelling per bestemming</h3>
            <p>Bekijk actuele weersinformatie zodat je nooit meer verrast wordt tijdens je reis.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📱</div>
            <h3>Mobielvriendelijk en snel</h3>
            <p>Onze app werkt soepel op elk apparaat, zodat je onderweg altijd toegang hebt tot je reisinfo.</p>
        </div>
    </section>

    <div class="features-cta">
        <a href="planner.php" class="btn-primary">Probeer de planner →</a>
    </div>
</main>

<style>
/* -------- Features Page -------- */
.features-page {
    padding: 140px 20px 120px;
    max-width: 1200px;
    margin: 0 auto;
    text-align: center;
    color: #FFD700;
}

.features-hero {
    margin-bottom: 60px;
}

.features-title {
    font-size: 2.8em;
    font-weight: 700;
    background: linear-gradient(135deg, #FFD700 0%, #D4AF37 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 15px;
}

.features-subtitle {
    color: #aaa;
    font-size: 1.2em;
    max-width: 600px;
    margin: 0 auto;
}

.features-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.feature-card {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(212, 175, 55, 0.2);
    border-radius: 20px;
    padding: 30px 20px;
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.1);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    border-color: rgba(255, 215, 0, 0.5);
    box-shadow: 0 12px 30px rgba(255, 215, 0, 0.2);
}

.feature-icon {
    font-size: 2.5em;
    margin-bottom: 15px;
}

.feature-card h3 {
    font-size: 1.3em;
    margin-bottom: 10px;
    color: #FFD700;
}

.feature-card p {
    color: #ccc;
    font-size: 1em;
    line-height: 1.5;
}

/* CTA Button */
.features-cta {
    margin-top: 60px;
}

.btn-primary {
    display: inline-block;
    background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
    color: #000;
    font-weight: 600;
    padding: 14px 30px;
    border-radius: 30px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.6);
}

/* -------- Light Mode -------- */
body.light-mode .features-page {
    color: #333;
}

body.light-mode .features-title {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

body.light-mode .feature-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    color: #333;
}

body.light-mode .feature-card h3 {
    color: #667eea;
}

body.light-mode .feature-card p {
    color: #555;
}

body.light-mode .feature-card:hover {
    border-color: rgba(102, 126, 234, 0.4);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
}

body.light-mode .btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}
</style>

<?php include 'includes/footer.php'; ?>

