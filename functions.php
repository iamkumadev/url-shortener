<?php
// functions.php
require_once 'config.php';

function generateShortCode() {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $code;
}

function createShortUrl($longUrl, $expiryDays = null) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Generate a unique short code
    $shortCode = generateShortCode();
    while (shortCodeExists($shortCode)) {
        $shortCode = generateShortCode();
    }
    
    // Set expiry date if provided
    $expiresAt = null;
    if ($expiryDays) {
        $expiresAt = date('Y-m-d H:i:s', strtotime("+$expiryDays days"));
    }
    
    $stmt = $conn->prepare("INSERT INTO short_urls (long_url, short_code, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $longUrl, $shortCode, $expiresAt);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return BASE_URL . '/' . $shortCode;
}

function shortCodeExists($shortCode) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $stmt = $conn->prepare("SELECT id FROM short_urls WHERE short_code = ?");
    $stmt->bind_param("s", $shortCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    $conn->close();
    return $exists;
}

function getLongUrl($shortCode) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $stmt = $conn->prepare("SELECT long_url FROM short_urls WHERE short_code = ? AND (expires_at IS NULL OR expires_at > NOW())");
    $stmt->bind_param("s", $shortCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    // Increment hit counter
    if ($row) {
        $conn->query("UPDATE short_urls SET hit_count = hit_count + 1 WHERE short_code = '$shortCode'");
    }
    
    $conn->close();
    return $row ? $row['long_url'] : null;
}