<?php
// public/mobile/report.php
header('Content-Type: application/json');

// ✅ Laravel API endpoint for public report submission
$apiUrl = "https://bfpkoronadalweb.rf.gd/api/citizen/public-report";

// Collect POST data from Expo app
$data = [
    'user_id' => $_POST['user_id'] ?? null,
    'title' => $_POST['title'] ?? '',
    'description' => $_POST['description'] ?? '',
    'location' => $_POST['location'] ?? '',
    'latitude' => $_POST['latitude'] ?? null,
    'longitude' => $_POST['longitude'] ?? null,
    'priority' => $_POST['priority'] ?? 'Normal'
];

// Send data to Laravel API
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);

if ($response === FALSE) {
    echo json_encode(["error" => "Failed to submit report"]);
    exit;
}

curl_close($ch);
echo $response;
