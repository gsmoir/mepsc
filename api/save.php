<?php

require_once "../config.php";

header("Content-Type: application/json; charset=UTF-8");

/*
|--------------------------------------------------------------------------
| Only POST Requests
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "status"  => false,
        "message" => "Invalid request."
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Read Form Values
|--------------------------------------------------------------------------
*/

$id = intval($_POST["id"] ?? 0);

$manipuri = trim($_POST["manipuri"] ?? "");
$english = trim($_POST["english"] ?? "");

$manipuri_audio = trim($_POST["manipuri_audio"] ?? "");
$english_audio = trim($_POST["english_audio"] ?? "");

$speaker = trim($_POST["speaker"] ?? "");
$domain = trim($_POST["domain"] ?? "");
$remarks = trim($_POST["remarks"] ?? "");

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if ($manipuri == "" || $english == "") {

    echo json_encode([
        "status" => false,
        "message" => "Manipuri and English sentences are required."
    ]);

    exit;
}

try {

    /*
    |--------------------------------------------------------------------------
    | INSERT
    |--------------------------------------------------------------------------
    */

    if ($id == 0) {

        $sql = "

            INSERT INTO sentence_pairs (

                manipuri,
                english,

                manipuri_audio,
                english_audio,

                speaker,
                domain,
                remarks

            )

            VALUES (

                :manipuri,
                :english,

                :manipuri_audio,
                :english_audio,

                :speaker,
                :domain,
                :remarks

            )

        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([

            ":manipuri" => $manipuri,
            ":english" => $english,

            ":manipuri_audio" => $manipuri_audio,
            ":english_audio" => $english_audio,

            ":speaker" => $speaker,
            ":domain" => $domain,
            ":remarks" => $remarks

        ]);

        echo json_encode([

            "status" => true,
            "message" => "Sentence added successfully."

        ]);

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    else {

        $sql = "

            UPDATE sentence_pairs

            SET

                manipuri = :manipuri,
                english = :english,

                manipuri_audio = :manipuri_audio,
                english_audio = :english_audio,

                speaker = :speaker,
                domain = :domain,
                remarks = :remarks

            WHERE id = :id

        ";

        $stmt = $db->prepare($sql);

        $stmt->execute([

            ":manipuri" => $manipuri,
            ":english" => $english,

            ":manipuri_audio" => $manipuri_audio,
            ":english_audio" => $english_audio,

            ":speaker" => $speaker,
            ":domain" => $domain,
            ":remarks" => $remarks,

            ":id" => $id

        ]);

        echo json_encode([

            "status" => true,
            "message" => "Sentence updated successfully."

        ]);

    }

}

catch (PDOException $e) {

    echo json_encode([

        "status" => false,
        "message" => $e->getMessage()

    ]);

}