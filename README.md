# URL Shortener

A simple PHP URL shortener application that allows you to:
- Create short URLs from long ones
- Track how many times each link is clicked
- Set expiration dates for links

## Features

- URL shortening with 6-character codes
- Hit counter for each short URL
- Optional link expiration
- Simple, clean interface

## Installation

1. Import the `sql/setup.sql` file into your MySQL database
2. Configure database settings in `config.php`
3. Upload files to your web server
4. Ensure your server is configured to route all requests to `redirect.php`

## Requirements

- PHP 7.0+
- MySQL 5.6+
- mod_rewrite enabled (for clean URLs)

## Configuration

Edit `config.php` to set your database credentials and base URL.