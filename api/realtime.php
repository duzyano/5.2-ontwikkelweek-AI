<?php
header('Content-Type: application/json');

// Parameters
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$time = $_GET['time'] ?? '';

if(!$from || !$to || !$time){
    echo json_encode(["error" => "Vul vertrekpunt, bestemming en tijd in."]);
    exit;
}

// Mock data: voorbeeld reizen
$legs = [
    [
        "type" => "trein",
        "line" => "IC 123",
        "from" => $from,
        "to" => $to,
        "departure" => $time,
        "arrival" => date("H:i", strtotime("$time +35 minutes")),
        "status" => "Op tijd"
    ],
    [
        "type" => "bus",
        "line" => "Bus 45",
        "from" => $from,
        "to" => $to,
        "departure" => date("H:i", strtotime("$time +15 minutes")),
        "arrival" => date("H:i", strtotime("$time +50 minutes")),
        "status" => "Op tijd"
    ]
];

echo json_encode(["legs" => $legs]);
