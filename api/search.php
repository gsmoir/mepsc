<?php

require_once "../config.php";

// Only allow these searchable columns
$allowedLanguages = ['manipuri', 'english'];

$language = $_GET['language'] ?? 'manipuri';
$keyword  = trim($_GET['keyword'] ?? '');

if (!in_array($language, $allowedLanguages)) {
    $language = 'manipuri';
}

try {

    if ($keyword === '') {

        // Show first 50 records when search box is empty
        $sql = "
            SELECT
                id,
                $language AS sentence
            FROM sentence_pairs
            ORDER BY id
            LIMIT 50
        ";

        $stmt = $db->query($sql);

    } else {

        // Search by selected language
        $sql = "
            SELECT
                id,
                $language AS sentence
            FROM sentence_pairs
            WHERE $language LIKE :keyword
            ORDER BY id
            LIMIT 50
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([
            ':keyword' => '%' . $keyword . '%'
        ]);
    }

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode(
        $rows,
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );

} catch (PDOException $e) {

    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode([
        "error" => $e->getMessage()
    ]);
}