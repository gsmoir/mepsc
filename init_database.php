<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: init_database.php
 *
 * Description:
 * Creates the MySQL database schema required by MEPSC.
 *
 * Safe to execute multiple times.
 *
 * Technology:
 * - PHP 8+
 * - MySQL (PDO)
 *
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
    corpus_id VARCHAR(100) NOT NULL PRIMARY KEY,

    manipuri TEXT NOT NULL,

    english TEXT NOT NULL,

    manipuri_audio TEXT NOT NULL,

    english_audio TEXT NOT NULL,

    speaker_id VARCHAR(100),

    domain VARCHAR(100),

    remarks TEXT,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;
SQL;

    $pdo->exec($sql);

    /*
    |--------------------------------------------------------------------------
    | Indexes
    |--------------------------------------------------------------------------
    */

    $pdo->exec(
        "CREATE INDEX idx_sentence_pairs_manipuri
         ON sentence_pairs (manipuri(255));"
    );

    $pdo->exec(
        "CREATE INDEX idx_sentence_pairs_english
         ON sentence_pairs (english(255));"
    );

    $pdo->exec(
        "CREATE INDEX idx_sentence_pairs_speaker
         ON sentence_pairs (speaker_id);"
    );

    $pdo->exec(
        "CREATE INDEX idx_sentence_pairs_domain
         ON sentence_pairs (domain);"
    );

} catch (PDOException $e) {

    /*
    |--------------------------------------------------------------------------
    | Ignore duplicate index errors
    |--------------------------------------------------------------------------
    |
    | Table creation uses IF NOT EXISTS, but CREATE INDEX in MySQL does not.
    |
    */

    if ($e->getCode() !== '42000') {

        http_response_code(500);

        exit(
            '<h2>Database Initialization Failed</h2>' .
            '<p>' .
            htmlspecialchars(
                $e->getMessage(),
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            ) .
            '</p>'
        );

    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>MEPSC Database Initialization</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
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

The MySQL database has been initialized successfully.

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
<th>Database Server</th>
<td><?php echo htmlspecialchars(DB_HOST); ?></td>
</tr>

<tr>
<th>Database</th>
<td><?php echo htmlspecialchars(DB_NAME); ?></td>
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