<?php
header('Content-Type: application/json');

$apiUrl = "https://bfpkoronadalweb.rf.gd/api/citizen/alerts";
echo file_get_contents($apiUrl);
