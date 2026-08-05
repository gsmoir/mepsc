<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: config.php
 * Description:
 * Global configuration file.
 *
 * Responsibilities:
 * - Application configuration
 * - PDO MySQL database connection
 * - Session initialization
 * - Global constants
 *
 * Technology:
 * - PHP 8+
 * - PDO (MySQL)
 *
 * Encoding:
 * - UTF-8
 * ============================================================================
 */

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Error Reporting
|--------------------------------------------------------------------------
*/
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

/*
|--------------------------------------------------------------------------
| Default Timezone
|--------------------------------------------------------------------------
*/
date_default_timezone_set('Asia/Kolkata');

/*
|--------------------------------------------------------------------------
| Internal Encoding
|--------------------------------------------------------------------------
*/
mb_internal_encoding('UTF-8');

/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Application Information
|--------------------------------------------------------------------------
*/
define('APP_NAME', 'LangdaiTranslate');
define('APP_VERSION', '1.0');

/*
|--------------------------------------------------------------------------
| Base Paths
|--------------------------------------------------------------------------
*/
define('BASE_PATH', __DIR__);

define(
    'MANIPURI_AUDIO_PATH',
    BASE_PATH . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . 'manipuri'
);

define(
    'ENGLISH_AUDIO_PATH',
    BASE_PATH . DIRECTORY_SEPARATOR . 'audio' . DIRECTORY_SEPARATOR . 'english'
);

/*
|--------------------------------------------------------------------------
| Audio URL Prefixes
|--------------------------------------------------------------------------
*/
define('MANIPURI_AUDIO_URL', 'audio/manipuri/');
define('ENGLISH_AUDIO_URL', 'audio/english/');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
|
| Change these credentials before deploying.
|
*/
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

/*
|--------------------------------------------------------------------------
| MySQL Database Configuration
|--------------------------------------------------------------------------
|
| Default XAMPP Settings
|
*/
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'mepsc');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/
try {

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_PORT,
        DB_NAME,
        DB_CHARSET
    );

    $pdo = new PDO(
        $dsn,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

} catch (PDOException $e) {

    // http_response_code(500);

    // exit('Database connection failed.');

    die($e->getMessage());
}
?>