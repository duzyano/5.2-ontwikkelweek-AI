<?php include 'includes/header.php'; ?>

<main>
    <!-- Hero Section -->
    <section class="hero" style="padding: 150px 30px 80px;">
        <div class="hero-content">
            <h1 class="hero-title">Neem contact op</h1>
            <p class="hero-subtitle">We horen graag van je! Vul het formulier hieronder in en we nemen zo snel mogelijk contact met je op.</p>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="planner" style="padding: 80px 30px;">
        <div class="planner-container">
            <div class="planner-card">
                <form action="contact_submit.php" method="post">
                    <div class="input-group">
                        <label for="name">Naam</label>
                        <input type="text" id="name" name="name" placeholder="Jouw naam" required>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="text" id="email" name="email" placeholder="Jouw e-mail" required>
                    </div>

                    <div class="input-group">
                        <label for="subject">Onderwerp</label>
                        <input type="text" id="subject" name="subject" placeholder="Onderwerp" required>
                    </div>

                    <div class="input-group">
                        <label for="message">Bericht</label>
                        <textarea id="message" name="message" placeholder="Typ hier je bericht..." rows="6" style="width:100%; padding:18px; border-radius:15px; border:2px solid rgba(212,175,55,0.3); background:#000; color:#D4AF37; resize:none;"></textarea>
                    </div>

                    <button type="submit" class="search-btn">Verstuur bericht</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
