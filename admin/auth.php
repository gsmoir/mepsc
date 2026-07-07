<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: admin/auth.php
 *
 * Description:
 * Authentication helper for all admin pages and APIs.
 *
 * This file must be included at the beginning of every protected
 * admin page or admin API.
 *
 * Technology:
 * - PHP 8+
 * ============================================================================
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/config.php';

/**
 * --------------------------------------------------------------------------
 * Check whether the administrator is logged in.
 * --------------------------------------------------------------------------
 *
 * @return bool
 */
function isAdminLoggedIn(): bool
{
    return isset($_SESSION['admin_logged_in']) &&
           $_SESSION['admin_logged_in'] === true;
}

/**
 * --------------------------------------------------------------------------
 * Require administrator authentication.
 * --------------------------------------------------------------------------
 *
 * Redirects unauthenticated users to the login page.
 * This function is intended for normal admin web pages.
 * --------------------------------------------------------------------------
 *
 * @return void
 */
function requireAdminLogin(): void
{
    if (!isAdminLoggedIn()) {

        header('Location: login.php');
        exit;
    }
}

/**
 * --------------------------------------------------------------------------
 * Require administrator authentication for API endpoints.
 * --------------------------------------------------------------------------
 *
 * Returns HTTP 401 with JSON response when authentication fails.
 * --------------------------------------------------------------------------
 *
 * @return void
 */
function requireAdminApiLogin(): void
{
    if (!isAdminLoggedIn()) {

        http_response_code(401);

        header('Content-Type: application/json; charset=UTF-8');

        echo json_encode(
            [
                'success' => false,
                'message' => 'Authentication required.'
            ],
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }
}

/**
 * --------------------------------------------------------------------------
 * Login administrator.
 * --------------------------------------------------------------------------
 *
 * @return void
 */
function adminLogin(): void
{
    session_regenerate_id(true);

    $_SESSION['admin_logged_in'] = true;
}

/**
 * --------------------------------------------------------------------------
 * Logout administrator.
 * --------------------------------------------------------------------------
 *
 * @return void
 */
function adminLogout(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}