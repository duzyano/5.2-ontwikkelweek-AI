<?php
/**
 * D&L Tripwise Database Configuration
 * Database connectie en helper functies
 */

// Database configuratie
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Pas aan naar jouw situatie
define('DB_PASS', ''); // Pas aan naar jouw situatie
define('DB_NAME', 'dl_tripwise');
define('DB_CHARSET', 'utf8mb4');

// Database connectie class
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            die("Database connectie mislukt: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Voorkom clonen
    private function __clone() {}
    
    // Voorkom unserialize
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}

// Helper functie voor database connectie
function getDB() {
    return Database::getInstance()->getConnection();
}

// Helper functie voor prepared statements
function query($sql, $params = []) {
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

// Helper functie voor SELECT queries
function select($sql, $params = []) {
    return query($sql, $params)->fetchAll();
}

// Helper functie voor single row
function selectOne($sql, $params = []) {
    return query($sql, $params)->fetch();
}

// Helper functie voor INSERT
function insert($table, $data) {
    $db = getDB();
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));
    
    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    $stmt = $db->prepare($sql);
    $stmt->execute($data);
    
    return $db->lastInsertId();
}

// Helper functie voor UPDATE
function update($table, $data, $where, $whereParams = []) {
    $db = getDB();
    $set = [];
    foreach (array_keys($data) as $column) {
        $set[] = "{$column} = :{$column}";
    }
    $setString = implode(', ', $set);
    
    $sql = "UPDATE {$table} SET {$setString} WHERE {$where}";
    $stmt = $db->prepare($sql);
    $stmt->execute(array_merge($data, $whereParams));
    
    return $stmt->rowCount();
}

// Helper functie voor DELETE
function delete($table, $where, $params = []) {
    $db = getDB();
    $sql = "DELETE FROM {$table} WHERE {$where}";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->rowCount();
}

// Test database connectie
function testConnection() {
    try {
        $db = getDB();
        $stmt = $db->query("SELECT 1");
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
```

---

## 📁 API File voor Stations

Maak: `api/stations.php`
```php
<?php
/**
 * Stations API
 * Retourneert alle stations voor autocomplete
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../includes/db_config.php';

try {
    // Haal alle actieve stations op
    $sql = "SELECT id, code, name, city, station_type 
            FROM stations 
            WHERE is_active = 1 
            ORDER BY name ASC";
    
    $stations = select($sql);
    
    // Format voor autocomplete
    $stationNames = array_map(function($station) {
        return $station['name'];
    }, $stations);
    
    echo json_encode($stationNames, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database fout',
        'message' => $e->getMessage()
    ]);
}
?>
```

---

## 📁 API File voor Realtime Data

Maak: `api/realtime.php`
```php
<?php
/**
 * Realtime Reis API
 * Simuleert reisdata op basis van stations
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../includes/db_config.php';

// Valideer parameters
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$time = $_GET['time'] ?? date('H:i');

if (empty($from) || empty($to)) {
    http_response_code(400);
    echo json_encode([
        'error' => 'Missing parameters',
        'message' => 'Van en naar parameters zijn verplicht'
    ]);
    exit;
}

try {
    // Zoek stations in database
    $fromStation = selectOne(
        "SELECT * FROM stations WHERE name LIKE ? LIMIT 1",
        ["%{$from}%"]
    );
    
    $toStation = selectOne(
        "SELECT * FROM stations WHERE name LIKE ? LIMIT 1",
        ["%{$to}%"]
    );
    
    if (!$fromStation || !$toStation) {
        throw new Exception('Station niet gevonden');
    }
    
    // Log zoekopdracht (als user ingelogd is)
    if (isset($_SESSION['user_id'])) {
        insert('search_history', [
            'user_id' => $_SESSION['user_id'],
            'from_station_id' => $fromStation['id'],
            'to_station_id' => $toStation['id'],
            'search_date' => date('Y-m-d'),
            'search_time' => $time,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
        ]);
    }
    
    // Genereer mock reisdata
    $response = generateMockTripData($fromStation, $toStation, $time);
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => $e->getMessage()
    ]);
}

function generateMockTripData($from, $to, $time) {
    $transportTypes = [
        ['type' => 'train', 'line' => 'IC 1234', 'duration' => 45],
        ['type' => 'train', 'line' => 'SPR 5678', 'duration' => 65],
        ['type' => 'bus', 'line' => 'Bus 300', 'duration' => 75]
    ];
    
    $legs = [];
    $baseTime = strtotime($time);
    
    foreach ($transportTypes as $index => $transport) {
        $departureTime = date('H:i', $baseTime + ($index * 1200)); // +20 min per optie
        $arrivalTime = date('H:i', $baseTime + ($index * 1200) + ($transport['duration'] * 60));
        
        $legs[] = [
            'type' => $transport['type'],
            'line' => $transport['line'],
            'from' => $from['name'],
            'to' => $to['name'],
            'departure' => $departureTime,
            'arrival' => $arrivalTime,
            'duration' => $transport['duration'],
            'platform' => rand(1, 12) . (rand(0, 1) ? 'a' : 'b'),
            'status' => rand(0, 10) > 8 ? 'delayed' : 'on_time',
            'delay' => rand(0, 10) > 8 ? rand(2, 15) : 0
        ];
    }
    
    return [
        'success' => true,
        'from' => $from['name'],
        'to' => $to['name'],
        'search_time' => $time,
        'legs' => $legs
    ];
}
?>
```

---

## 📁 User Authentication Functions

Maak: `includes/auth_functions.php`
```php
<?php
/**
 * Authentication Functions
 * Gebruikersbeheer functies
 */

require_once 'db_config.php';

// Start session als nog niet gestart
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Registreer nieuwe gebruiker
 */
function registerUser($username, $email, $password, $firstName = null, $lastName = null) {
    // Validatie
    if (strlen($password) < 8) {
        return ['success' => false, 'message' => 'Wachtwoord moet minimaal 8 karakters zijn'];
    }
    
    // Check of username al bestaat
    $existing = selectOne(
        "SELECT id FROM users WHERE username = ? OR email = ?",
        [$username, $email]
    );
    
    if ($existing) {
        return ['success' => false, 'message' => 'Gebruikersnaam of email bestaat al'];
    }
    
    // Hash wachtwoord
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Genereer verification token
    $verificationToken = bin2hex(random_bytes(32));
    
    // Voeg gebruiker toe
    try {
        $userId = insert('users', [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'verification_token' => $verificationToken,
            'theme_preference' => 'dark'
        ]);
        
        // Log activiteit
        logActivity($userId, 'user_registered', 'users', $userId, 'Nieuwe gebruiker geregistreerd');
        
        return [
            'success' => true,
            'user_id' => $userId,
            'message' => 'Account succesvol aangemaakt',
            'verification_token' => $verificationToken
        ];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Registratie mislukt: ' . $e->getMessage()];
    }
}

/**
 * Login gebruiker
 */
function loginUser($username, $password) {
    $user = selectOne(
        "SELECT * FROM users WHERE (username = ? OR email = ?) AND is_active = 1",
        [$username, $username]
    );
    
    if (!$user) {
        return ['success' => false, 'message' => 'Gebruiker niet gevonden'];
    }
    
    if (!password_verify($password, $user['password'])) {
        return ['success' => false, 'message' => 'Onjuist wachtwoord'];
    }
    
    // Update last login
    update('users', 
        ['last_login' => date('Y-m-d H:i:s')],
        'id = ?',
        [$user['id']]
    );
    
    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['theme'] = $user['theme_preference'];
    
    // Log activiteit
    logActivity($user['id'], 'user_login', 'users', $user['id'], 'Gebruiker ingelogd');
    
    return [
        'success' => true,
        'user' => [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'is_admin' => $user['is_admin']
        ]
    ];
}

/**
 * Logout gebruiker
 */
function logoutUser() {
    if (isset($_SESSION['user_id'])) {
        logActivity($_SESSION['user_id'], 'user_logout', 'users', $_SESSION['user_id'], 'Gebruiker uitgelogd');
    }
    
    session_unset();
    session_destroy();
    
    return ['success' => true, 'message' => 'Succesvol uitgelogd'];
}

/**
 * Check of gebruiker ingelogd is
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check of gebruiker admin is
 */
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}

/**
 * Get huidige gebruiker
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return selectOne(
        "SELECT id, username, email, first_name, last_name, theme_preference, is_admin 
         FROM users WHERE id = ?",
        [$_SESSION['user_id']]
    );
}

/**
 * Update gebruikersprofiel
 */
function updateUserProfile($userId, $data) {
    $allowedFields = ['first_name', 'last_name', 'phone', 'theme_preference'];
    $updateData = [];
    
    foreach ($data as $key => $value) {
        if (in_array($key, $allowedFields)) {
            $updateData[$key] = $value;
        }
    }
    
    if (empty($updateData)) {
        return ['success' => false, 'message' => 'Geen geldige velden om te updaten'];
    }
    
    try {
        update('users', $updateData, 'id = ?', [$userId]);
        
        // Update session theme als deze gewijzigd is
        if (isset($updateData['theme_preference'])) {
            $_SESSION['theme'] = $updateData['theme_preference'];
        }
        
        logActivity($userId, 'profile_updated', 'users', $userId, 'Profiel bijgewerkt');
        
        return ['success' => true, 'message' => 'Profiel succesvol bijgewerkt'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Update mislukt: ' . $e->getMessage()];
    }
}

/**
 * Wijzig wachtwoord
 */
function changePassword($userId, $oldPassword, $newPassword) {
    $user = selectOne("SELECT password FROM users WHERE id = ?", [$userId]);
    
    if (!$user) {
        return ['success' => false, 'message' => 'Gebruiker niet gevonden'];
    }
    
    if (!password_verify($oldPassword, $user['password'])) {
        return ['success' => false, 'message' => 'Huidig wachtwoord is onjuist'];
    }
    
    if (strlen($newPassword) < 8) {
        return ['success' => false, 'message' => 'Nieuw wachtwoord moet minimaal 8 karakters zijn'];
    }
    
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
    try {
        update('users', 
            ['password' => $hashedPassword],
            'id = ?',
            [$userId]
        );
        
        logActivity($userId, 'password_changed', 'users', $userId, 'Wachtwoord gewijzigd');
        
        return ['success' => true, 'message' => 'Wachtwoord succesvol gewijzigd'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Wijziging mislukt: ' . $e->getMessage()];
    }
}

/**
 * Log activiteit
 */
function logActivity($userId, $action, $tableName = null, $recordId = null, $description = null) {
    try {
        insert('activity_logs', [
            'user_id' => $userId,
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'description' => $description,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ]);
    } catch (Exception $e) {
        // Logging mag niet de hoofdfunctie blokkeren
        error_log('Activity logging failed: ' . $e->getMessage());
    }
}

/**
 * Require login (redirect als niet ingelogd)
 */
function requireLogin($redirectUrl = 'login.php') {
    if (!isLoggedIn()) {
        header('Location: ' . $redirectUrl);
        exit;
    }
}

/**
 * Require admin (redirect als niet admin)
 */
function requireAdmin($redirectUrl = 'index.php') {
    if (!isAdmin()) {
        header('Location: ' . $redirectUrl);
        exit;
    }
}
?>
```

---

## 📁 Trip Functions

Maak: `includes/trip_functions.php`
```php
<?php
/**
 * Trip Functions
 * Reis gerelateerde functies
 */

require_once 'db_config.php';

/**
 * Zoek station op naam
 */
function findStation($name) {
    return selectOne(
        "SELECT * FROM stations WHERE name LIKE ? LIMIT 1",
        ["%{$name}%"]
    );
}

/**
 * Haal alle stations op
 */
function getAllStations($activeOnly = true) {
    $sql = "SELECT * FROM stations";
    if ($activeOnly) {
        $sql .= " WHERE is_active = 1";
    }
    $sql .= " ORDER BY name ASC";
    
    return select($sql);
}

/**
 * Maak nieuwe reis aan
 */
function createTrip($userId, $fromStationId, $toStationId, $departureDate, $departureTime, $travelType = 'departure') {
    try {
        $tripId = insert('trips', [
            'user_id' => $userId,
            'from_station_id' => $fromStationId,
            'to_station_id' => $toStationId,
            'departure_date' => $departureDate,
            'departure_time' => $departureTime,
            'travel_type' => $travelType,
            'trip_status' => 'planned'
        ]);
        
        logActivity($userId, 'trip_created', 'trips', $tripId, 'Nieuwe reis gepland');
        
        return ['success' => true, 'trip_id' => $tripId];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Reis aanmaken mislukt: ' . $e->getMessage()];
    }
}

/**
 * Haal gebruikersreizen op
 */
function getUserTrips($userId, $status = null, $limit = 50) {
    $sql = "SELECT t.*, 
            s1.name as from_station_name, s1.city as from_city,
            s2.name as to_station_name, s2.city as to_city
            FROM trips t
            JOIN stations s1 ON t.from_station_id = s1.id
            JOIN stations s2 ON t.to_station_id = s2.id
            WHERE t.user_id = ?";
    
    $params = [$userId];
    
    if ($status) {
        $sql .= " AND t.trip_status = ?";
        $params[] = $status;
    }
    
    $sql .= " ORDER BY t.departure_date DESC, t.departure_time DESC LIMIT ?";
    $params[] = $limit;
    
    return select($sql, $params);
}

/**
 * Haal favoriete routes op
 */
function getFavoriteRoutes($userId) {
    $sql = "SELECT fr.*, 
            s1.name as from_station_name,
            s2.name as to_station_name
            FROM favorite_routes fr
            JOIN stations s1 ON fr.from_station_id = s1.id
            JOIN stations s2 ON fr.to_station_id = s2.id
            WHERE fr.user_id = ? AND fr.is_active = 1
            ORDER BY fr.usage_count DESC";
    
    return select($sql, [$userId]);
}

/**
 * Voeg favoriete route toe
 */
function addFavoriteRoute($userId, $fromStationId, $toStationId, $routeName = null) {
    // Check of route al bestaat
    $existing = selectOne(
        "SELECT id FROM favorite_routes 
         WHERE user_id = ? AND from_station_id = ? AND to_station_id = ?",
        [$userId, $fromStationId, $toStationId]
    );
    
    if ($existing) {
        // Reactiveer als inactive
        update('favorite_routes',
            ['is_active' => 1],
            'id = ?',
            [$existing['id']]
        );
        return ['success' => true, 'message' => 'Route geactiveerd'];
    }
    
    try {
        $routeId = insert('favorite_routes', [
            'user_id' => $userId,
            'from_station_id' => $fromStationId,
            'to_station_id' => $toStationId,
            'route_name' => $routeName
        ]);
        
        return ['success' => true, 'route_id' => $routeId];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Toevoegen mislukt: ' . $e->getMessage()];
    }
}

/**
 * Verwijder favoriete route
 */
function removeFavoriteRoute($userId, $routeId) {
    try {
        update('favorite_routes',
            ['is_active' => 0],
            'id = ? AND user_id = ?',
            [$routeId, $userId]
        );
        
        return ['success' => true, 'message' => 'Route verwijderd'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => 'Verwijderen mislukt: ' . $e->getMessage()];
    }
}

/**
 * Haal populaire routes op (laatste 30 dagen)
 */
function getPopularRoutes($limit = 10) {
    $sql = "SELECT 
            s1.name as from_station,
            s2.name as to_station,
            s1.id as from_id,
            s2.id as to_id,
            COUNT(*) as search_count
            FROM search_history sh
            JOIN stations s1 ON sh.from_station_id = s1.id
            JOIN stations s2 ON sh.to_station_id = s2.id
            WHERE sh.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            GROUP BY sh.from_station_id, sh.to_station_id
            ORDER BY search_count DESC
            LIMIT ?";
    
    return select($sql, [$limit]);
}
?>
```

---

## 🚀 Installatie Instructies

### Stap 1: Importeer Database
```bash
# Via commandline:
mysql -u root -p < dl_tripwise_database.sql

# Of via phpMyAdmin:
# 1. Open phpMyAdmin
# 2. Klik op "Import"
# 3. Selecteer het SQL bestand
# 4. Klik op "Go"
```

### Stap 2: Configureer Database Connectie
Bewerk `includes/db_config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'jouw_gebruikersnaam');
define('DB_PASS', 'jouw_wachtwoord');
define('DB_NAME', 'dl_tripwise');
```

### Stap 3: Test de Connectie
Maak `test_db.php`:
```php
<?php
require_once 'includes/db_config.php';

if (testConnection()) {
    echo "✅ Database connectie succesvol!<br>";
    
    $stations = select("SELECT COUNT(*) as count FROM stations");
    echo "📍 Aantal stations: " . $stations[0]['count'] . "<br>";
    
    $users = select("SELECT COUNT(*) as count FROM users");
    echo "👤 Aantal gebruikers: " . $users[0]['count'];
} else {
    echo "❌ Database connectie mislukt!";
}
?>
```

---

Nu heb je een complete, werkende database met:
- ✅ 40+ Nederlandse stations
- ✅ User management systeem
- ✅ Trip planning functionaliteit
- ✅ Favoriete routes
- ✅ Zoekgeschiedenis
- ✅ Notifications systeem
- ✅ Ticket management
- ✅ Reviews & ratings
- ✅ Activity logging
- ✅ API endpoints

Klaar om te gebruiken! 🎉Retry<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&L Tripwise - Jouw slimme reispartner</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizpastedLmaak nu bij mijn index.php een inlog / registreer knop volledig werkend, met een crud systeem die volledig werkt op een admin account en normale acount, zodat alles gemakkelijk is om toe te voegen en verwijderenIk ga een volledig werkend login/registratie systeem maken met CRUD functionaliteit voor zowel admin als normale gebruikers. Dit wordt een complete oplossing!
1️⃣ Update index.php (voeg login/register buttons toe aan navbar)
php<?php 
session_start();
require_once 'includes/db_config.php';
require_once 'includes/auth_functions.php';

// Check of gebruiker ingelogd is
$isLoggedIn = isLoggedIn();
$currentUser = $isLoggedIn ? getCurrentUser() : null;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&L Tripwise - Jouw slimme reispartner</title>
    <style>
        /* ... Alle bestaande CSS blijft hetzelfde ... */
        
        /* Voeg deze nieuwe styles toe voor auth buttons */
        .auth-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .auth-btn {
            padding: 10px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid #D4AF37;
            background: transparent;
            color: #D4AF37;
        }

        .auth-btn.login {
            background: transparent;
            color: #D4AF37;
        }

        .auth-btn.register {
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            color: #000;
            border: none;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        }

        .user-menu {
            position: relative;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37 0%, #FFD700 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.5);
        }

        .dropdown-menu {
            position: absolute;
            top: 60px;
            right: 0;
            background: #1a1a1a;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 15px;
            min-width: 200px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
            display: none;
            z-index: 1000;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 20px;
            color: #D4AF37;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background: rgba(212, 175, 55, 0.1);
            padding-left: 25px;
        }

        .admin-badge {
            display: inline-block;
            background: #FFD700;
            color: #000;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7em;
            margin-left: 5px;
            font-weight: bold;
        }

        /* Light mode overrides */
        body.light-mode .auth-btn.login {
            color: #667eea;
            border-color: #667eea;
        }

        body.light-mode .auth-btn.register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        body.light-mode .user-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        body.light-mode .dropdown-menu {
            background: white;
            border: 1px solid #e0e0e0;
        }

        body.light-mode .dropdown-menu a {
            color: #333;
            border-bottom: 1px solid #f0f0f0;
        }

        body.light-mode .dropdown-menu a:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        body.light-mode .admin-badge {
            background: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
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
                
                <?php if ($isLoggedIn): ?>
                    <!-- Ingelogde gebruiker menu -->
                    <li class="user-menu">
                        <div class="user-avatar" onclick="toggleDropdown()">
                            <?php echo strtoupper(substr($currentUser['username'], 0, 2)); ?>
                            <?php if ($currentUser['is_admin']): ?>
                                <span class="admin-badge">A</span>
                            <?php endif; ?>
                        </div>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="dashboard.php">
                                📊 Dashboard
                            </a>
                            <a href="my-trips.php">
                                🚆 Mijn Reizen
                            </a>
                            <a href="profile.php">
                                👤 Profiel
                            </a>
                            <?php if ($currentUser['is_admin']): ?>
                                <a href="admin/index.php">
                                    ⚙️ Admin Panel
                                </a>
                            <?php endif; ?>
                            <a href="logout.php">
                                🚪 Uitloggen
                            </a>
                        </div>
                    </li>
                <?php else: ?>
                    <!-- Login/Register buttons -->
                    <li>
                        <div class="auth-buttons">
                            <a href="login.php" class="auth-btn login">Inloggen</a>
                            <a href="register.php" class="auth-btn register">Registreren</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">☰</button>
        </div>
    </nav>

    <!-- Rest van je bestaande HTML blijft hetzelfde -->
    <!-- Hero Section, Features, etc... -->

    <script>
        // Bestaande theme toggle code...
        function toggleTheme() {
            const body = document.body;
            const themeButton = document.getElementById('themeToggle');
            body.classList.toggle('light-mode');
            
            if (body.classList.contains('light-mode')) {
                localStorage.setItem('theme', 'light');
                themeButton.textContent = '🌙 Dark Mode';
            } else {
                localStorage.setItem('theme', 'dark');
                themeButton.textContent = '☀️ Light Mode';
            }
        }

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

        // User dropdown toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (dropdown && !userMenu.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Rest van je bestaande JavaScript...
    </script>
</body>
</html>
2️⃣ Login Page (login.php)
php<?php
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
