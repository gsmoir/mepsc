<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/admin/get.php
 * Description:
 * Retrieves a single sentence pair for editing in the administrator portal.
 *
 * Specification v1.1
 * ------------------
 * - Administrator only.
 * - Used by the "Load" button in admin/index.php.
 * - Returns all editable fields except the automatically generated audio
 *   filenames.
 *
 * Request
 * -------
 * GET
 *      api/admin/get.php?corpus_id=00001
 *
 * Response
 * --------
 * {
 *     "success": true,
 *     "data": {
 *         "corpus_id": "00001",
 *         "manipuri": "...",
 *         "manipuri_transliteration": "...",
 *         "english": "...",
 *         "speaker_id": "...",
 *         "domain": "...",
 *         "remarks": "..."
 *     }
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

/*
|--------------------------------------------------------------------------
| Read Input
|--------------------------------------------------------------------------
*/
$corpusId = trim($_GET['corpus_id'] ?? '');

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/
if (!preg_match('/^[0-9]{5}$/', $corpusId)) {

    jsonResponse([
        'success' => false,
        'message' => 'Corpus ID must be exactly five digits.'
    ], 400);
}

try {

    /*
    |--------------------------------------------------------------------------
    | Retrieve Record
    |--------------------------------------------------------------------------
    */
    $stmt = $db->prepare(
        'SELECT
            corpus_id,
            manipuri,
            manipuri_transliteration,
            english,
            speaker_id,
            domain,
            remarks
         FROM sentence_pairs
         WHERE corpus_id = ?
         LIMIT 1'
    );

    $stmt->execute([$corpusId]);

    $record = $stmt->fetch();

    if ($record === false) {

        jsonResponse([
            'success' => false,
            'message' => 'Sentence pair not found.'
        ], 404);
    }

    jsonResponse([
        'success' => true,
        'data' => [
            'corpus_id'                => $record['corpus_id'],
            'manipuri'                 => $record['manipuri'],
            'manipuri_transliteration' => $record['manipuri_transliteration'],
            'english'                  => $record['english'],
            'speaker_id'               => $record['speaker_id'],
            'domain'                   => $record['domain'],
            'remarks'                  => $record['remarks']
        ]
    ]);

} catch (PDOException $e) {

    jsonResponse([
        'success' => false,
        'message' => 'Unable to retrieve sentence pair.'
    ], 500);

}