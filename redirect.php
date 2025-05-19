<?php
// redirect.php
require_once 'functions.php';

$requestUri = $_SERVER['REQUEST_URI'];
$shortCode = ltrim(parse_url($requestUri, PHP_URL_PATH), '/');

if (!empty($shortCode)) {
    $longUrl = getLongUrl($shortCode);
    
    if ($longUrl) {
        header("Location: $longUrl", true, 301);
        exit;
    }
}

// If no match found, redirect to home
header("Location: " . BASE_URL);
exit;