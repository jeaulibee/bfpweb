<?php
// public/mobile/announcements.php
header('Content-Type: application/json');

// ✅ Laravel API endpoint for announcements
$apiUrl = "https://bfpkoronadalweb.rf.gd/api/citizen/announcements";

// Forward GET request and output the response
$response = file_get_contents($apiUrl);

if ($response === FALSE) {
    echo json_encode(["error" => "Unable to fetch announcements"]);
    exit;
}

echo $response;
