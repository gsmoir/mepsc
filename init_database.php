<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: init_database.php
 *
 * Description:
 * Creates the SQLite database schema required by MEPSC.
 *
 * Safe to execute multiple times.
 *
 * Technology:
 * - PHP 8+
 * - SQLite (PDO)
 * *
 * Usage:
 *     http://localhost/MEPSC/init_database.php
 *
 * After successful execution, the sentence_pairs table will be created
 * if it does not already exist.
 * ============================================================================
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';

try {

    /*
    |--------------------------------------------------------------------------
    | Create sentence_pairs table
    |--------------------------------------------------------------------------
    */
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS sentence_pairs
(
    corpus_id TEXT PRIMARY KEY,

    manipuri TEXT NOT NULL,

    english TEXT NOT NULL,

    manipuri_audio TEXT NOT NULL,

    english_audio TEXT NOT NULL,

    speaker_id TEXT,

    domain TEXT,

    remarks TEXT,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
SQL;

    $pdo->exec($sql);

    /*
    |--------------------------------------------------------------------------
    | Indexes
    |--------------------------------------------------------------------------
    |
    | These indexes improve search performance for the public portal.
    |
    */

    $pdo->exec(
        "CREATE INDEX IF NOT EXISTS idx_sentence_pairs_manipuri
         ON sentence_pairs(manipuri);"
    );

    $pdo->exec(
        "CREATE INDEX IF NOT EXISTS idx_sentence_pairs_english
         ON sentence_pairs(english);"
    );

    $pdo->exec(
        "CREATE INDEX IF NOT EXISTS idx_sentence_pairs_speaker
         ON sentence_pairs(speaker_id);"
    );

    $pdo->exec(
        "CREATE INDEX IF NOT EXISTS idx_sentence_pairs_domain
         ON sentence_pairs(domain);"
    );

} catch (PDOException $e) {

    http_response_code(500);

    exit(
        '<h2>Database Initialization Failed</h2>' .
        '<p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>'
    );
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>MEPSC Database Initialization</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">
                        MEPSC Database Initialization
                    </h3>
                </div>

                <div class="card-body">

                    <div class="alert alert-success mb-4">

                        <strong>Success!</strong>

                        <br><br>

                        The SQLite database has been initialized successfully.

                    </div>

                    <table class="table table-bordered">

                        <tbody>

                        <tr>
                            <th width="220">Application</th>
                            <td><?php echo htmlspecialchars(APP_NAME); ?></td>
                        </tr>

                        <tr>
                            <th>Version</th>
                            <td><?php echo htmlspecialchars(APP_VERSION); ?></td>
                        </tr>

                        <tr>
                            <th>Database File</th>
                            <td><?php echo htmlspecialchars(DATABASE_FILE); ?></td>
                        </tr>

                        <tr>
                            <th>Main Table</th>
                            <td>sentence_pairs</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td class="text-success">
                                Ready
                            </td>
                        </tr>

                        </tbody>

                    </table>

                    <a href="index.php"
                       class="btn btn-primary">
                        Go to Public Portal
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>