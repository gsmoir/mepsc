<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/admin/import.php
 *
 * Description:
 * Imports sentence pairs from a CSV file.
 *
 * Authentication:
 * - Administrator login required.
 *
 * Request Method:
 * - POST (multipart/form-data)
 *
 * CSV Columns (exact order)
 * -------------------------
 * 1. Corpus ID
 * 2. Manipuri
 * 3. English
 * 4. Speaker ID
 * 5. Domain
 * 6. Remarks
 *
 * Audio filenames are automatically generated:
 *      Mxxxxx.mp3
 *      Exxxxx.mp3
 *
 * Existing Corpus IDs are updated.
 * New Corpus IDs are inserted.
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
| Validate Upload
|--------------------------------------------------------------------------
*/
if (
    !isset($_FILES['csv_file']) ||
    $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK
) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'CSV file upload failed.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$tmpFile = $_FILES['csv_file']['tmp_name'];

$handle = fopen($tmpFile, 'r');

if ($handle === false) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to read CSV file.'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$inserted = 0;
$updated = 0;
$skipped = 0;
$rowNumber = 0;

$pdo->beginTransaction();

try {

    while (($row = fgetcsv($handle)) !== false) {

        $rowNumber++;

        /*
        |--------------------------------------------------------------------------
        | Skip empty rows
        |--------------------------------------------------------------------------
        */
        if (
            count(array_filter($row, static fn($v) => trim((string)$v) !== '')) === 0
        ) {
            continue;
        }

        /*
        |--------------------------------------------------------------------------
        | Skip header row automatically
        |--------------------------------------------------------------------------
        */
        if (
            $rowNumber === 1 &&
            isset($row[0]) &&
            stripos(trim($row[0]), 'corpus') !== false
        ) {
            continue;
        }

        if (count($row) < 6) {
            $skipped++;
            continue;
        }

        $corpusId  = trim($row[0]);
        $manipuri  = trim($row[1]);
        $english   = trim($row[2]);
        $speakerId = trim($row[3]);
        $domain    = trim($row[4]);
        $remarks   = trim($row[5]);

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */
        if (
            !preg_match('/^\d{5}$/', $corpusId) ||
            $manipuri === '' ||
            $english === ''
        ) {
            $skipped++;
            continue;
        }

        $manipuriAudio = 'M' . $corpusId . '.mp3';
        $englishAudio  = 'E' . $corpusId . '.mp3';

        /*
        |--------------------------------------------------------------------------
        | Check existing record
        |--------------------------------------------------------------------------
        */
        $check = $pdo->prepare(
            "SELECT COUNT(*)
             FROM sentence_pairs
             WHERE corpus_id = :corpus_id"
        );

        $check->execute([
            ':corpus_id' => $corpusId
        ]);

        $exists = ((int)$check->fetchColumn()) > 0;

        if ($exists) {

            $update = $pdo->prepare(
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

            $update->execute([
                ':manipuri'       => $manipuri,
                ':english'        => $english,
                ':manipuri_audio' => $manipuriAudio,
                ':english_audio'  => $englishAudio,
                ':speaker_id'     => $speakerId,
                ':domain'         => $domain,
                ':remarks'        => $remarks,
                ':corpus_id'      => $corpusId
            ]);

            $updated++;

        } else {

            $insert = $pdo->prepare(
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

            $insert->execute([
                ':corpus_id'      => $corpusId,
                ':manipuri'       => $manipuri,
                ':english'        => $english,
                ':manipuri_audio' => $manipuriAudio,
                ':english_audio'  => $englishAudio,
                ':speaker_id'     => $speakerId,
                ':domain'         => $domain,
                ':remarks'        => $remarks
            ]);

            $inserted++;
        }
    }

    fclose($handle);

    $pdo->commit();

    echo json_encode([
        'success'  => true,
        'message'  => 'CSV import completed successfully.',
        'inserted' => $inserted,
        'updated'  => $updated,
        'skipped'  => $skipped
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    if (is_resource($handle)) {
        fclose($handle);
    }

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'CSV import failed.'
    ], JSON_UNESCAPED_UNICODE);
}