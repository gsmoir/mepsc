<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/public/sentence.php
 *
 * Description:
 * Returns complete information for a single sentence pair.
 *
 * Usage
 * -----
 * API (AJAX):
 *      sentence.php?id=00001&format=json
 *
 * Browser:
 *      sentence.php?id=00001
 *
 * Features
 * --------
 * - Fetch sentence by Corpus ID
 * - JSON response for AJAX
 * - Bootstrap HTML page for browser viewing
 * - Manipuri audio player
 * - English audio player
 *
 * Technology
 * ----------
 * - PHP 8+
 * - PDO SQLite
 * - Bootstrap 5
 * ============================================================================
 */

declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/config.php';

$id = trim($_GET['id'] ?? '');

if ($id === '') {

    http_response_code(400);

    exit('Missing Corpus ID.');
}

$stmt = $pdo->prepare(
    "
    SELECT
        corpus_id,
        manipuri,
        english,
        manipuri_audio,
        english_audio,
        speaker_id,
        domain,
        remarks,
        created_at
    FROM sentence_pairs
    WHERE corpus_id = :id
    LIMIT 1
    "
);

$stmt->bindValue(':id', $id, PDO::PARAM_STR);

$stmt->execute();

$sentence = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sentence) {

    http_response_code(404);

    exit('Sentence not found.');
}

/*
|--------------------------------------------------------------------------
| JSON Response
|--------------------------------------------------------------------------
*/
if (
    isset($_GET['format']) &&
    strtolower($_GET['format']) === 'json'
) {

    header('Content-Type: application/json; charset=UTF-8');

    echo json_encode(
        $sentence,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    exit;
}

/*
|--------------------------------------------------------------------------
| HTML Response
|--------------------------------------------------------------------------
*/

$manipuriAudio = '../../audio/manipuri/' . $sentence['manipuri_audio'];
$englishAudio  = '../../audio/english/' . $sentence['english_audio'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Sentence <?php echo htmlspecialchars($sentence['corpus_id']); ?>
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">
                        Sentence Details
                    </h3>

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="220">
                                Corpus ID
                            </th>
                            <td>
                                <?php echo htmlspecialchars($sentence['corpus_id']); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Manipuri
                            </th>
                            <td>
                                <?php echo nl2br(htmlspecialchars($sentence['manipuri'])); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                English
                            </th>
                            <td>
                                <?php echo nl2br(htmlspecialchars($sentence['english'])); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Speaker ID
                            </th>
                            <td>
                                <?php echo htmlspecialchars($sentence['speaker_id']); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Domain
                            </th>
                            <td>
                                <?php echo htmlspecialchars($sentence['domain']); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Remarks
                            </th>
                            <td>
                                <?php echo nl2br(htmlspecialchars($sentence['remarks'])); ?>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Created At
                            </th>
                            <td>
                                <?php echo htmlspecialchars($sentence['created_at']); ?>
                            </td>
                        </tr>

                        <tr>

                            <th>
                                Manipuri Audio
                            </th>

                            <td>

                                <audio controls preload="none">

                                    <source
                                        src="<?php echo htmlspecialchars($manipuriAudio); ?>"
                                        type="audio/mpeg"
                                    >

                                    Your browser does not support HTML5 audio.

                                </audio>

                            </td>

                        </tr>

                        <tr>

                            <th>
                                English Audio
                            </th>

                            <td>

                                <audio controls preload="none">

                                    <source
                                        src="<?php echo htmlspecialchars($englishAudio); ?>"
                                        type="audio/mpeg"
                                    >

                                    Your browser does not support HTML5 audio.

                                </audio>

                            </td>

                        </tr>

                    </table>

                    <div class="mt-4">

                        <a
                            href="../../index.php"
                            class="btn btn-secondary"
                        >
                            Back to Search
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>