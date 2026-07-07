<?php

require_once "../config.php";

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    echo json_encode([
        "status" => false,
        "message" => "POST request required."
    ]);

    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid ID."
    ]);

    exit;
}

try {

    // Check if the record exists
    $check = $db->prepare("
        SELECT id
        FROM sentence_pairs
        WHERE id = :id
    ");

    $check->execute([
        ':id' => $id
    ]);

    if (!$check->fetch()) {

        echo json_encode([
            "status" => false,
            "message" => "Sentence not found."
        ]);

        exit;
    }

    // Delete record
    $delete = $db->prepare("
        DELETE FROM sentence_pairs
        WHERE id = :id
    ");

    $delete->execute([
        ':id' => $id
    ]);

    echo json_encode([
        "status" => true,
        "message" => "Sentence deleted successfully."
    ]);

}
catch(PDOException $e){

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);

}
?>