<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D&L Tripwise - Jouw slimme reispartner</title>
  <link rel="stylesheet" href="style.css"> <!-- eventueel externe CSS -->
  <style>
            * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            overflow-x: hidden;
            background: #000;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }

        .navbar.scrolled {
            padding: 15px 0;
            background: rgba(0, 0, 0, 0.98);
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
            background-clip: text;
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
            position: relative;
        }

        .theme-toggle {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }

        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
        }

        /* Light Mode Styles */
        body.light-mode {
            background: #f8f9fa;
        }

        body.light-mode .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 20px rgba(102, 126, 234, 0.2);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        body.light-mode .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
        }

        body.light-mode .nav-logo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        body.light-mode .nav-menu a {
            color: #667eea;
        }

        body.light-mode .nav-menu a:hover {
            color: #764ba2;
        }

        body.light-mode .nav-menu a::after {
            background: #764ba2;
        }

        body.light-mode .theme-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        body.light-mode .mobile-menu-btn {
            color: #667eea;
        }

        body.light-mode .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body.light-mode .hero::before {
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        }

        body.light-mode .hero::after {
            display: none;
        }

        body.light-mode .hero-content {
            color: white;
        }

        body.light-mode .hero-title {
            background: white;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: none;
        }

        body.light-mode .hero-subtitle {
            color: rgba(255, 255, 255, 0.95);
        }

        body.light-mode .scroll-indicator {
            color: white;
        }

        body.light-mode .btn-primary {
            background: white;
            color: #667eea;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        body.light-mode .btn-primary:hover {
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.3);
        }

        body.light-mode .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        body.light-mode .btn-secondary:hover {
            background: white;
            color: #667eea;
        }

        body.light-mode .features {
            background: #f8f9fa;
        }

        body.light-mode .section-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        body.light-mode .section-subtitle {
            color: #666;
        }

        body.light-mode .feature-card {
            background: white;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        body.light-mode .feature-card:hover {
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        body.light-mode .feature-title {
            color: #333;
        }

        body.light-mode .feature-description {
            color: #666;
        }

        body.light-mode .planner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body.light-mode .planner-card {
            background: white;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        body.light-mode .input-group label {
            color: #333;
        }

        body.light-mode input[type="text"],
        body.light-mode input[type="datetime-local"],
        body.light-mode select {
            background: white;
            color: #333;
            border: 2px solid #e0e0e0;
        }

        body.light-mode input[type="text"]:focus,
        body.light-mode input[type="datetime-local"]:focus,
        body.light-mode select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        body.light-mode input::placeholder {
            color: #999;
        }

        body.light-mode select {
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat right 18px center;
        }

        body.light-mode select option {
            background: white;
            color: #333;
        }

        body.light-mode .swap-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        body.light-mode .swap-btn:hover {
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        body.light-mode .search-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        body.light-mode .search-btn:hover {
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        body.light-mode .quick-link {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        body.light-mode .quick-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        body.light-mode .result-card {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        body.light-mode .result-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }

        body.light-mode .result-header {
            border-bottom: 2px solid #e0e0e0;
        }

        body.light-mode .travel-time {
            color: #333;
        }

        body.light-mode .duration {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        body.light-mode .route-info {
            color: #666;
        }

        body.light-mode .transport-icon {
            background: white;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        body.light-mode .transport-icon.train {
            background: linear-gradient(135deg, #ffd93d 0%, #ffb800 100%);
            color: #333;
            border: none;
        }

        body.light-mode .transport-icon.bus {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
            border: none;
        }

        body.light-mode .transport-icon.tram {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a39f 100%);
            color: white;
            border: none;
        }

        body.light-mode .transport-icon.metro {
            background: linear-gradient(135deg, #95e1d3 0%, #7cc9bf 100%);
            color: #333;
            border: none;
        }

        body.light-mode .arrow {
            color: #999;
        }

        body.light-mode .spinner {
            border: 4px solid rgba(102, 126, 234, 0.2);
            border-top: 4px solid #667eea;
        }

        body.light-mode .loading-text {
            color: #667eea;
        }

        body.light-mode .stats {
            background: white;
        }

        body.light-mode .stat-item {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
        }

        body.light-mode .stat-item:hover {
            border-color: rgba(102, 126, 234, 0.3);
        }

        body.light-mode .stat-number {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        body.light-mode .stat-label {
            color: #666;
        }

        body.light-mode .footer {
            background: #2c3e50;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        body.light-mode .footer-section h3 {
            color: white;
        }

        body.light-mode .footer-section a {
            color: rgba(255, 255, 255, 0.8);
        }

        body.light-mode .footer-section a:hover {
            color: white;
        }

        body.light-mode .footer-bottom {
            color: rgba(255, 255, 255, 0.6);
        }

        .nav-menu a:hover {
            color: #FFD700;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #FFD700;
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
            color: #D4AF37;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #000000 100%);
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
            background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
            animation: float 20s infinite ease-in-out;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%);
            animation: float 25s infinite ease-in-out reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(-50px, 50px) rotate(180deg); }
        }

        .hero-content {
            max-width: 1200px;
            text-align: center;
            color: #D4AF37;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 4em;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 50%, #D4AF37 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
        }

        .hero-subtitle {
            font-size: 1.5em;
            margin-bottom: 40px;
            color: #B8960F;
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
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 215, 0, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: #D4AF37;
            border: 2px solid #D4AF37;
        }

        .btn-secondary:hover {
            background: #D4AF37;
            color: #000;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: #D4AF37;
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
            background: #0a0a0a;
        }

        .section-title {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2em;
            color: #888;
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
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid rgba(212, 175, 55, 0.2);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(212, 175, 55, 0.3);
            border-color: rgba(255, 215, 0, 0.5);
        }

        .feature-icon {
            font-size: 3.5em;
            margin-bottom: 20px;
            filter: grayscale(0.3) brightness(1.2);
        }

        .feature-title {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: #D4AF37;
        }

        .feature-description {
            color: #999;
            line-height: 1.6;
        }

        /* Planner Section */
        .planner {
            padding: 100px 30px;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        }

        .planner-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .planner-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            color: #D4AF37;
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
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 15px;
            font-size: 1em;
            transition: all 0.3s ease;
            outline: none;
            background: #000;
            color: #D4AF37;
        }

        input[type="text"]:focus, input[type="datetime-local"]:focus, select:focus {
            border-color: #FFD700;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
        }

        input::placeholder {
            color: #666;
        }

        select {
            cursor: pointer;
            appearance: none;
            background: #000 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23D4AF37' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat right 18px center;
            background-size: 12px;
        }

        select option {
            background: #000;
            color: #D4AF37;
        }

        .swap-btn {
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.3em;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
            transition: all 0.3s ease;
            z-index: 10;
            font-weight: bold;
        }

        .swap-btn:hover {
            transform: translateY(-50%) rotate(180deg);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.6);
        }

        .search-btn {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border: none;
            border-radius: 15px;
            font-size: 1.2em;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
        }

        .quick-links {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .quick-link {
            background: rgba(212, 175, 55, 0.1);
            color: #D4AF37;
            padding: 10px 18px;
            border-radius: 25px;
            font-size: 0.9em;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        .quick-link:hover {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            transform: translateY(-2px);
            border-color: transparent;
        }

        /* Results Section */
        .results {
            padding: 40px 0;
            display: none;
        }

        .result-card {
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.3);
            border-color: rgba(255, 215, 0, 0.5);
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
        }

        .travel-time {
            font-size: 1.5em;
            font-weight: bold;
            color: #D4AF37;
        }

        .duration {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.95em;
            font-weight: 700;
        }

        .route-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #888;
        }

        .route-steps {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .transport-icon {
            background: #000;
            padding: 10px 15px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 2px 8px rgba(212, 175, 55, 0.1);
        }

        .transport-icon.train { 
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border-color: transparent;
        }
        .transport-icon.bus { 
            background: rgba(212, 175, 55, 0.2);
            color: #D4AF37;
        }
        .transport-icon.tram { 
            background: rgba(212, 175, 55, 0.15);
            color: #B8960F;
        }
        .transport-icon.metro { 
            background: rgba(255, 215, 0, 0.1);
            color: #D4AF37;
        }

        .arrow {
            color: #666;
            font-size: 1.2em;
        }

        .loading {
            text-align: center;
            padding: 50px;
            display: none;
        }

        .spinner {
            border: 4px solid rgba(212, 175, 55, 0.2);
            border-top: 4px solid #D4AF37;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        .loading-text {
            color: #D4AF37;
            font-weight: 600;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Statistics Section */
        .stats {
            padding: 100px 30px;
            background: #000;
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
            background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
            border-radius: 20px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            border-color: rgba(255, 215, 0, 0.5);
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 3.5em;
            font-weight: bold;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.2em;
            color: #888;
        }

        /* Footer */
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
  <!-- Navigatiebalk -->
  <nav class="navbar" id="navbar">
      <div class="nav-container">
          <div class="nav-logo" onclick="window.location.href='index.php'">D&L Tripwise</div>
          <ul class="nav-menu">
              <li><button class="theme-toggle" onclick="toggleTheme()" id="themeToggle">☀️ Light Mode</button></li>
              <li><a href="index.php">Home</a></li>
              <li><a href="features.php">Functies</a></li>
              <li><a href="planner.php">Plan reis</a></li>
              <li><a href="about.php">Over ons</a></li>
              <li><a href="contact.php">Contact</a></li>
          </ul>
          <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
      </div>
  </nav>

  <main>
    
  <script>


function toggleTheme() {
    const body = document.body;
    const themeButton = document.getElementById('themeToggle');

    // Wissel tussen dark en light mode
    body.classList.toggle('light-mode');

    // Sla voorkeur op in localStorage
    if (body.classList.contains('light-mode')) {
        localStorage.setItem('theme', 'light');
        themeButton.textContent = '🌙 Dark Mode';
    } else {
        localStorage.setItem('theme', 'dark');
        themeButton.textContent = '☀️ Light Mode';
    }
}

// Bij laden van de pagina: controleer voorkeur
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const themeButton = document.getElementById('themeToggle');

    if (savedTheme === 'light') {
        document.body.classList.add('light-mode');
        themeButton.textContent = '🌙 Dark Mode';
    } else {
        document.body.classList.remove('light-mode');
        themeButton.textContent = '☀️ Light Mode';
    }
});
</script>






































































