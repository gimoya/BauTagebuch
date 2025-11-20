<?php
/**
 * PHP Proxy for Google Drive Downloads
 * Fetches files from Google Drive server-side to bypass CORS restrictions
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get file ID from request
$fileId = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$fileId) {
    http_response_code(400);
    echo json_encode(['error' => 'File ID is required']);
    exit;
}

// Construct Google Drive download URL
$url = "https://drive.google.com/uc?export=view&id=" . urlencode($fileId);

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

// Execute request
$data = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
$error = curl_error($ch);
curl_close($ch);

// Check for errors
if ($error) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch file: ' . $error]);
    exit;
}

if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo json_encode(['error' => 'HTTP error: ' . $httpCode]);
    exit;
}

// Check if we got HTML (error page)
if (strpos($contentType, 'text/html') !== false || strpos($data, '<html') !== false) {
    http_response_code(400);
    echo json_encode(['error' => 'File is not accessible or requires authentication']);
    exit;
}

// Return file as base64 encoded JSON
$base64 = base64_encode($data);
echo json_encode([
    'success' => true,
    'data' => $base64,
    'contentType' => $contentType,
    'size' => strlen($data)
]);

