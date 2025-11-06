<?php
header('Content-Type: application/json');

// Database connectie
$host = 'localhost';
$db   = 'reizen';
$user = 'root';
$pass = '';
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Haal start & end van GET
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

if (!$start || !$end) {
    echo json_encode(['error' => 'Start en eindstation zijn verplicht']);
    exit;
}

// Haal station IDs
$stmt = $pdo->prepare("SELECT id FROM stations WHERE naam LIKE ?");
$stmt->execute([$start]);
$startId = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT id FROM stations WHERE naam LIKE ?");
$stmt->execute([$end]);
$endId = $stmt->fetchColumn();

if (!$startId || !$endId) {
    echo json_encode(['error' => 'Station niet gevonden']);
    exit;
}

// Haal verbindingen
$stmt = $pdo->prepare("
    SELECT c.vertrek, c.aankomst, l.type, l.naam
    FROM connections c
    JOIN lijnen l ON c.lijn_id = l.id
    WHERE c.start_station = ? AND c.end_station = ?
    ORDER BY c.vertrek ASC
");
$stmt->execute([$startId, $endId]);
$connections = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Voeg dag naam toe bij vertrek
foreach ($connections as &$conn) {
    $today = date('Y-m-d');
    $time = $conn['vertrek'];
    $datetime = new DateTime("$today $time");
    $conn['dag'] = $datetime->format('l'); // Woensdag etc.
    $conn['vertrek_formatted'] = $datetime->format('H:i');
    $conn['aankomst_formatted'] = (new DateTime("$today {$conn['aankomst']}"))->format('H:i');
}

echo json_encode([
    'start' => $start,
    'end' => $end,
    'connections' => $connections
], JSON_PRETTY_PRINT);
?>
