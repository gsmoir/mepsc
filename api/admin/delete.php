<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/admin/delete.php
 *
 * Description:
 * Deletes a sentence pair from the corpus.
 *
 * Authentication:
 * - Administrator login required.
 *
 * Request Method:
 * - POST
 *
 * POST Parameters
 * ---------------
 * corpus_id
 *
 * Response:
 * JSON
 *
 * Technology:
 * - PHP 8+
 * - PDO SQLite
 * ============================================================================
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/admin/auth.php';

requireAdminApiLogin();

/*
|--------------------------------------------------------------------------
| Read Input
|--------------------------------------------------------------------------
*/
$corpusId = trim($_POST['corpus_id'] ?? '');

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/
if ($corpusId === '') {

    http_response_code(400);

    echo json_encode(
        [
            'success' => false,
            'message' => 'Corpus ID is required.'
        ],
        JSON_UNESCAPED_UNICODE
    );

    exit;
}

if (!preg_match('/^\d{5}$/', $corpusId)) {

    http_response_code(400);

    echo json_encode(
        [
            'success' => false,
            'message' => 'Invalid Corpus ID.'
        ],
        JSON_UNESCAPED_UNICODE
    );

    exit;
}

try {

    /*
    |--------------------------------------------------------------------------
    | Check Existence
    |--------------------------------------------------------------------------
    */
    $check = $pdo->prepare(
        "
        SELECT COUNT(*)
        FROM sentence_pairs
        WHERE corpus_id = :corpus_id
        "
    );

    $check->execute([
        ':corpus_id' => $corpusId
    ]);

    if ((int)$check->fetchColumn() === 0) {

        http_response_code(404);

        echo json_encode(
            [
                'success' => false,
                'message' => 'Sentence not found.'
            ],
            JSON_UNESCAPED_UNICODE
        );

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Record
    |--------------------------------------------------------------------------
    */
    $delete = $pdo->prepare(
        "
        DELETE FROM sentence_pairs
        WHERE corpus_id = :corpus_id
        "
    );

    $delete->execute([
        ':corpus_id' => $corpusId
    ]);

    echo json_encode(
        [
            'success' => true,
            'message' => 'Sentence deleted successfully.'
        ],
        JSON_UNESCAPED_UNICODE
    );

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode(
        [
            'success' => false,
            'message' => 'Database operation failed.'
        ],
        JSON_UNESCAPED_UNICODE
    );
}