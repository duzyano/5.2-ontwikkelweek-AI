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
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $error = 'Vul alle velden in';
    } else {
        $result = loginUser($username, $password);
        
        if ($result['success']) {
            // Remember me functionaliteit
            if ($remember) {
                setcookie('remember_token', bin2hex(random_bytes(32)), time() + (86400 * 30), '/');
            }
            
            header('Location: dashboard.php');
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
    <title>Inloggen - D&L Tripwise</title>
    <style>
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

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .login-card {
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
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-group label {
            color: #888;
            font-size: 0.9em;
            cursor: pointer;
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <h1>D&L Tripwise</h1>
                <p>Welkom terug!</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    ⚠️ <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    ✅ <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Gebruikersnaam of Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Voer je gebruikersnaam in"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Wachtwoord</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Voer je wachtwoord in"
                            required
                        >
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Onthoud mij</label>
                </div>

                <button type="submit" class="btn-submit">
                    🔓 Inloggen
                </button>
            </form>

            <div class="divider">of</div>

            <div class="links">
                <p style="color: #888; margin-bottom: 10px;">Nog geen account?</p>
                <a href="register.php">Registreer nu →</a>
            </div>

            <div class="links" style="margin-top: 20px;">
                <a href="forgot-password.php" style="font-size: 0.9em;">Wachtwoord vergeten?</a>
            </div>
        </div>

        <div class="back-home">
            <a href="index.php">← Terug naar home</a>
        </div>
    </div>
</body>
</html>