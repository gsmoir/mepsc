<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: admin/logout.php
 *
 * Description:
 * Logs out the administrator and redirects to the login page.
 *
 * Technology:
 * - PHP 8+
 * ============================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Logout Administrator
|--------------------------------------------------------------------------
*/
adminLogout();

/*
|--------------------------------------------------------------------------
| Redirect to Login Page
|--------------------------------------------------------------------------
*/
header('Location: login.php');
exit;