<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/admin/next_id.php
 * Description:
 * Returns the next available 5-digit Corpus ID.
 *
 * Specification v1.2
 * ------------------
 * - Administrator only.
 * - IDs are exactly five numeric digits.
 * - Maximum ID is 99999.
 *
 * Request
 * -------
 * GET
 *
 * Response
 * --------
 * {
 *     "success": true,
 *     "next_id": "00001"
 * }
 * ============================================================================
 */

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config.php';

/*
|--------------------------------------------------------------------------
| Administrator Authentication
|--------------------------------------------------------------------------
*/
if (!isAdminLoggedIn()) {

    jsonResponse([
        'success' => false,
        'message' => 'Unauthorized.'
    ], 401);
}

/*
|--------------------------------------------------------------------------
| Request Method
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {

    jsonResponse([
        'success' => false,
        'message' => 'Method not allowed.'
    ], 405);
}

try {

    /*
    |--------------------------------------------------------------------------
    | Find Highest Existing Corpus ID
    |--------------------------------------------------------------------------
    |
    | Corpus IDs are stored as TEXT, therefore cast to INTEGER before taking
    | the maximum value.
    |
    */
    $stmt = $db->query(
        'SELECT MAX(CAST(corpus_id AS INTEGER))
         FROM sentence_pairs'
    );

    $maxId = $stmt->fetchColumn();

    if ($maxId === null) {
        $next = 1;
    } else {
        $next = ((int)$maxId) + 1;
    }

    /*
    |--------------------------------------------------------------------------
    | Maximum Limit
    |--------------------------------------------------------------------------
    */
    if ($next > 99999) {

        jsonResponse([
            'success' => false,
            'message' => 'Maximum Corpus ID (99999) has been reached.'
        ], 409);
    }

    /*
    |--------------------------------------------------------------------------
    | Return Next ID
    |--------------------------------------------------------------------------
    */
    jsonResponse([
        'success' => true,
        'next_id' => sprintf('%05d', $next)
    ]);

} catch (PDOException $e) {

    jsonResponse([
        'success' => false,
        'message' => 'Unable to determine the next Corpus ID.'
    ], 500);

}