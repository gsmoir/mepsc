<?php

require_once "../config.php";

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "status"  => false,
        "message" => "POST request required."
    ]);

    exit;
}

if (!isset($_FILES["csv"])) {

    echo json_encode([
        "status"  => false,
        "message" => "No CSV file uploaded."
    ]);

    exit;
}

$tmpFile = $_FILES["csv"]["tmp_name"];

if (!is_uploaded_file($tmpFile)) {

    echo json_encode([
        "status"  => false,
        "message" => "Invalid uploaded file."
    ]);

    exit;
}

$handle = fopen($tmpFile, "r");

if ($handle === false) {

    echo json_encode([
        "status"  => false,
        "message" => "Unable to open CSV."
    ]);

    exit;
}

/*
----------------------------------------------------------
Skip Header Row
----------------------------------------------------------
*/

fgetcsv($handle);

/*
----------------------------------------------------------
Prepared Statement
----------------------------------------------------------
*/

$stmt = $db->prepare("

INSERT INTO sentence_pairs(

    manipuri,
    english,

    manipuri_audio,
    english_audio,

    speaker,
    domain,
    remarks

)

VALUES(

    :manipuri,
    :english,

    :manipuri_audio,
    :english_audio,

    :speaker,
    :domain,
    :remarks

)

");

$count = 0;

while (($row = fgetcsv($handle)) !== false) {

    if (count($row) < 7) {
        continue;
    }

    $stmt->execute([

        ":manipuri"       => trim($row[0]),
        ":english"        => trim($row[1]),

        ":manipuri_audio" => trim($row[2]),
        ":english_audio"  => trim($row[3]),

        ":speaker"        => trim($row[4]),
        ":domain"         => trim($row[5]),
        ":remarks"        => trim($row[6])

    ]);

    $count++;

}

fclose($handle);

echo json_encode([

    "status"  => true,
    "message" => "$count sentence pairs imported successfully."

]);

?>