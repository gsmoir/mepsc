<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/admin/save.php
 *
 * Description:
 * Creates a new sentence pair or updates an existing one.
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
 * manipuri
 * english
 * speaker_id
 * domain
 * remarks
 *
 * Audio filenames are automatically generated as:
 *      M<corpus_id>.mp3
 *      E<corpus_id>.mp3
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
$corpusId  = trim($_POST['corpus_id'] ?? '');
$manipuri  = trim($_POST['manipuri'] ?? '');
$english   = trim($_POST['english'] ?? '');
$speakerId = trim($_POST['speaker_id'] ?? '');
$domain    = trim($_POST['domain'] ?? '');
$remarks   = trim($_POST['remarks'] ?? '');

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/
if (
    $corpusId === '' ||
    $manipuri === '' ||
    $english === ''
) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Corpus ID, Manipuri and English are required.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

if (!preg_match('/^\d{5}$/', $corpusId)) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Corpus ID must be exactly 5 digits.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

/*
|--------------------------------------------------------------------------
| Auto-generated Audio Filenames
|--------------------------------------------------------------------------
*/
$manipuriAudio = 'M' . $corpusId . '.mp3';
$englishAudio  = 'E' . $corpusId . '.mp3';

/*
|--------------------------------------------------------------------------
| Determine whether record exists
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare(
    "SELECT COUNT(*) FROM sentence_pairs
     WHERE corpus_id = :corpus_id"
);

$stmt->execute([
    ':corpus_id' => $corpusId
]);

$exists = ((int)$stmt->fetchColumn()) > 0;

try {

    if ($exists) {

        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */
        $stmt = $pdo->prepare(
            "
            UPDATE sentence_pairs
            SET
                manipuri = :manipuri,
                english = :english,
                manipuri_audio = :manipuri_audio,
                english_audio = :english_audio,
                speaker_id = :speaker_id,
                domain = :domain,
                remarks = :remarks
            WHERE corpus_id = :corpus_id
            "
        );

        $stmt->execute([
            ':manipuri'        => $manipuri,
            ':english'         => $english,
            ':manipuri_audio'  => $manipuriAudio,
            ':english_audio'   => $englishAudio,
            ':speaker_id'      => $speakerId,
            ':domain'          => $domain,
            ':remarks'         => $remarks,
            ':corpus_id'       => $corpusId
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Sentence updated successfully.'
        ], JSON_UNESCAPED_UNICODE);

    } else {

        /*
        |--------------------------------------------------------------------------
        | INSERT
        |--------------------------------------------------------------------------
        */
        $stmt = $pdo->prepare(
            "
            INSERT INTO sentence_pairs
            (
                corpus_id,
                manipuri,
                english,
                manipuri_audio,
                english_audio,
                speaker_id,
                domain,
                remarks
            )
            VALUES
            (
                :corpus_id,
                :manipuri,
                :english,
                :manipuri_audio,
                :english_audio,
                :speaker_id,
                :domain,
                :remarks
            )
            "
        );

        $stmt->execute([
            ':corpus_id'       => $corpusId,
            ':manipuri'        => $manipuri,
            ':english'         => $english,
            ':manipuri_audio'  => $manipuriAudio,
            ':english_audio'   => $englishAudio,
            ':speaker_id'      => $speakerId,
            ':domain'          => $domain,
            ':remarks'         => $remarks
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Sentence added successfully.'
        ], JSON_UNESCAPED_UNICODE);
    }

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Database operation failed.'
    ], JSON_UNESCAPED_UNICODE);
}