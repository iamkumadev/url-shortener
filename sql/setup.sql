-- setup.sql - SQL to create the database tables
CREATE TABLE short_urls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    long_url VARCHAR(255) NOT NULL,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    hit_count INT DEFAULT 0,
    expires_at DATETIME DEFAULT NULL
);