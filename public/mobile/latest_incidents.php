<?php
header('Content-Type: application/json');

$apiUrl = "https://bfpkoronadalweb.rf.gd/api/incidents/latest";

echo file_get_contents($apiUrl);
