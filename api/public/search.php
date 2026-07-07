<?php
/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: api/public/search.php
 *
 * Description:
 * Public Search API
 *
 * Features
 * --------
 * - Live search
 * - Search Manipuri
 * - Search English
 * - Returns JSON
 *
 * Query Parameters
 * ----------------
 * q      : Search keyword
 * field  : manipuri | english
 *
 * Technology
 * ----------
 * - PHP 8+
 * - PDO SQLite
 * ============================================================================
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

require_once dirname(__DIR__, 2) . '/config.php';

$q = trim($_GET['q'] ?? '');
$field = strtolower(trim($_GET['field'] ?? ''));

/*
|--------------------------------------------------------------------------
| Empty Search
|--------------------------------------------------------------------------
*/
if ($q === '') {
    echo json_encode([], JSON_UNESCAPED_UNICODE);
    exit;
}

/*
|--------------------------------------------------------------------------
| Validate Search Field
|--------------------------------------------------------------------------
*/
$allowedFields = [
    'manipuri',
    'english'
];

if (!in_array($field, $allowedFields, true)) {
    $field = 'manipuri';
}

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/
$sql = "
    SELECT
        corpus_id,
        manipuri,
        english
    FROM
        sentence_pairs
    WHERE
        {$field} LIKE :keyword
    ORDER BY
        corpus_id
    LIMIT 100
";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(
    ':keyword',
    '%' . $q . '%',
    PDO::PARAM_STR
);

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(
    $results,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
exit;
?>