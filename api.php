<?php
header('Content-Type: application/json; charset=utf-8');

// Database configuratie
$host = 'localhost';
$dbname = 'reizen';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database connectie mislukt', 'message' => $e->getMessage()]);
    exit;
}

// Query parameters
$action = $_GET['action'] ?? '';
$query  = $_GET['query'] ?? '';
$from   = $_GET['from'] ?? '';
$to     = $_GET['to'] ?? '';

// Actie router
switch($action) {
    case 'search_station':
        searchStation($pdo, $query);
        break;
    case 'plan_route':
        planRoute($pdo, $from, $to);
        break;
    default:
        echo json_encode(['error' => 'Ongeldige actie']);
        break;
}

// Functies

function searchStation($pdo, $query) {
    if (!$query) {
        echo json_encode([]);
        return;
    }
    $stmt = $pdo->prepare("SELECT id, naam, type, latitude, longitude FROM stations WHERE naam LIKE ? LIMIT 10");
    $stmt->execute(["%$query%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
}

function planRoute($pdo, $from, $to) {
    if (!$from || !$to) {
        echo json_encode(['error' => 'Vanaf en naar stations vereist']);
        return;
    }

    // Zoek stations exact
    $stmt = $pdo->prepare("SELECT * FROM stations WHERE naam = ? LIMIT 1");
    $stmt->execute([$from]);
    $start = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->execute([$to]);
    $end = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$start || !$end) {
        echo json_encode(['error' => 'Stations niet gevonden']);
        return;
    }

    // Simuleer routeplanning (later kun je echte route-data integreren)
    $route = [
        'from' => $start['naam'],
        'to' => $end['naam'],
        'legs' => [
            [
                'type' => 'bus',
                'line' => '12',
                'departure' => date('H:i', strtotime('+10 minutes')),
                'arrival' => date('H:i', strtotime('+35 minutes')),
                'from' => $start['naam'],
                'to' => $end['naam'],
            ]
        ]
    ];

    echo json_encode($route);
}
?>
