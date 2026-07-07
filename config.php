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
 * - PDO SQLite database connection
 * - Session initialization
 * - Global constants
 *
 * Technology:
 * - PHP 8+
 * - PDO (SQLite)
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
|
| Disable error display in production.
| Enable logging if required.
|
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
define('APP_NAME', 'MEPSC');
define('APP_VERSION', '1.0');

/*
|--------------------------------------------------------------------------
| Base Paths
|--------------------------------------------------------------------------
*/
define('BASE_PATH', __DIR__);
define('DATABASE_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'database');
define('DATABASE_FILE', DATABASE_PATH . DIRECTORY_SEPARATOR . 'mepsc.sqlite');

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
| Database Connection
|--------------------------------------------------------------------------
*/
try {
    $pdo = new PDO('sqlite:' . DATABASE_FILE);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Improve SQLite concurrency
    $pdo->exec('PRAGMA foreign_keys = ON;');
    $pdo->exec('PRAGMA journal_mode = WAL;');
    $pdo->exec('PRAGMA synchronous = NORMAL;');

} catch (PDOException $e) {
    http_response_code(500);

    exit(
        'Database connection failed.'
    );
}
?>