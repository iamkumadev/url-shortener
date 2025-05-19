<?php
// index.php
require_once 'functions.php';

$shortUrl = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $longUrl = trim($_POST['long_url']);
    $expiryDays = isset($_POST['expiry_days']) ? (int)$_POST['expiry_days'] : null;
    
    if (filter_var($longUrl, FILTER_VALIDATE_URL)) {
        $shortUrl = createShortUrl($longUrl, $expiryDays);
    } else {
        $error = 'Please enter a valid URL';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>URL Shortener</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="text" name="long_url" placeholder="Enter your long URL" required>
            <div class="expiry-option">
                <label>Expire after (days, optional):</label>
                <input type="number" name="expiry_days" min="1">
            </div>
            <button type="submit">Shorten</button>
        </form>
        
        <?php if ($shortUrl): ?>
            <div class="result">
                <p>Your short URL:</p>
                <a href="<?= htmlspecialchars($shortUrl) ?>" target="_blank"><?= htmlspecialchars($shortUrl) ?></a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>