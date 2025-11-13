<?php
/**
 * Environment Configuration
 * Set different configurations for development, staging, and production
 */

// Detect environment (you can set this manually or use server variables)
$environment = isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'production';

// You can also detect by domain
if (isset($_SERVER['HTTP_HOST'])) {
    if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
        strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false ||
        strpos($_SERVER['HTTP_HOST'], 'dev.') === 0) {
        $environment = 'development';
    } elseif (strpos($_SERVER['HTTP_HOST'], 'staging.') === 0 || 
              strpos($_SERVER['HTTP_HOST'], 'test.') === 0) {
        $environment = 'staging';
    }
}

// Environment-specific configurations
switch ($environment) {
    case 'development':
        // Development settings
        define('APP_DEBUG', true);
        define('APP_ENV', 'development');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        ini_set('log_errors', 1);
        break;
        
    case 'staging':
        // Staging settings
        define('APP_DEBUG', true);
        define('APP_ENV', 'staging');
        error_reporting(E_ALL);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        break;
        
    case 'production':
    default:
        // Production settings
        define('APP_DEBUG', false);
        define('APP_ENV', 'production');
        error_reporting(0);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        break;
}

// Common settings
define('APP_NAME', 'Smart Archival & Information System');
define('APP_VERSION', '1.0.0');
define('APP_TIMEZONE', 'Asia/Kolkata'); // Change as per your location

// Set timezone
date_default_timezone_set(APP_TIMEZONE);

// File upload settings
define('MAX_FILE_SIZE', 50 * 1024 * 1024); // 50MB
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']);

// Session settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
ini_set('session.use_strict_mode', 1);

// Security headers
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

// Error logging
if (APP_DEBUG) {
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
}

// Create logs directory if it doesn't exist
$logs_dir = __DIR__ . '/../logs';
if (!file_exists($logs_dir)) {
    mkdir($logs_dir, 0755, true);
}
?>