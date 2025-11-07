<?php
session_start();
require_once 'includes/db_config.php';
require_once 'includes/auth_functions.php';

// Redirect als al ingelogd
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $terms = isset($_POST['terms']);
    
    // Validatie
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Vul alle verplichte velden in';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Ongeldig email adres';
    } elseif (strlen($password) < 8) {
        $error = 'Wachtwoord moet minimaal 8 karakters zijn';
    } elseif ($password !== $password_confirm) {
        $error = 'Wachtwoorden komen niet overeen';
    } elseif (!$terms) {
        $error = 'Je moet akkoord gaan met de voorwaarden';
    } else {
        $result = registerUser($username, $email, $password, $firstName, $lastName);
        
        if ($result['success']) {
            $success = 'Account succesvol aangemaakt! Je kunt nu inloggen.';
            // Auto-login na registratie
            loginUser($username, $password);
            header('Location: dashboard.php?welcome=1');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - D&L Tripwise</title>
    <style>
        /* Gebruik dezelfde styling als login.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            max-width: 500px;
            width: 100%;
        }

        .register-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border-radius: 25px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(212, 175, 55, 0.3);
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo h1 {
            font-size: 2.5em;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .logo p {
            color: #888;
            font-size: 1em;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #D4AF37;
            font-weight: 600;
            margin-bottom: 10px;
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
            color: #666;
            font-size: 1.2em;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 16px 16px 16px 50px;
            background: #000;
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 12px;
            color: #D4AF37;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #FFD700;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 25px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin-top: 2px;
        }

        .checkbox-group label {
            color: #888;
            font-size: 0.9em;
            cursor: pointer;
            line-height: 1.5;
        }

        .checkbox-group label a {
            color: #D4AF37;
            text-decoration: none;
        }

        .checkbox-group label a:hover {
            color: #FFD700;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border: none;
            border-radius: 12px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            color: #666;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: rgba(212, 175, 55, 0.2);
        }

        .divider::before {
            left: 0;
        }

        .divider::after {
            right: 0;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .links a:hover {
            color: #FFD700;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 0.95em;
        }

        .alert-error {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: #ff6b6b;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #4caf50;
        }

        .back-home {
            text-align: center;
            margin-top: 30px;
        }

        .back-home a {
            color: #888;
            text-decoration: none;
            font-size: 0.9em;
            transition: color 0.3s ease;
        }

        .back-home a:hover {
            color: #D4AF37;
        }

        .password-strength {
            margin-top: 10px;
            height: 4px;
            background: #333;
            border-radius: 2px;
            overflow: hidden;
            display: none;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            width: 0;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: #ff6b6b;
        }

        .password-strength-bar.medium {
            width: 66%;
            background: #ffd700;
        }

        .password-strength-bar.strong {
            width: 100%;
            background: #4caf50;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="logo">
                <h1>D&L Tripwise</h1>
                <p>Maak je account aan</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="registerForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">Voornaam</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                placeholder="Voornaam"
                                value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Achternaam</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                placeholder="Achternaam"
                                value=" <?php echo htmlspecialchars($_POST['last_name'])
                                value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Gebruikersnaam *</label>
                    <div class="input-wrapper">
                        <span class="input-icon">@</span>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Kies een gebruikersnaam"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <div class="input-wrapper">
                        <span class="input-icon">📧</span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="jouw@email.nl"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord *</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Min. 8 karakters"
                            required
                            oninput="checkPasswordStrength(this.value)"
                        >
                    </div>
                    <div class="password-strength" id="passwordStrength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Bevestig Wachtwoord *</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input 
                            type="password" 
                            id="password_confirm" 
                            name="password_confirm" 
                            placeholder="Herhaal je wachtwoord"
                            required
                        >
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Ik ga akkoord met de <a href="terms.php" target="_blank">algemene voorwaarden</a> 
                        en het <a href="privacy.php" target="_blank">privacybeleid</a>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    ✨ Account aanmaken
                </button>
            </form>

            <div class="divider">of</div>

            <div class="links">
                <p style="color: #888; margin-bottom: 10px;">Heb je al een account?</p>
                <a href="login.php">Log hier in →</a>
            </div>
        </div>

        <div class="back-home">
            <a href="index.php">← Terug naar home</a>
        </div>
    </div>

    <script>
        function checkPasswordStrength(password) {
            const strengthIndicator = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            
            if (password.length === 0) {
                strengthIndicator.style.display = 'none';
                return;
            }
            
            strengthIndicator.style.display = 'block';
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthBar.className = 'password-strength-bar';
            
            if (strength <= 1) {
                strengthBar.classList.add('weak');
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        }

        // Validatie bij submit
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirm').value;
            
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Wachtwoorden komen niet overeen!');
            }
        });
    </script>
</body>
</html>