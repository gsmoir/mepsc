<?php

require_once "../config.php";

header("Content-Type: application/json; charset=UTF-8");

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if($id<=0){
    echo json_encode([
        "status"=>false,
        "message"=>"Invalid ID"
    ]);
    exit;
}

$stmt=$db->prepare("
SELECT
        id,
        manipuri,
        english,
        manipuri_audio,
        english_audio,
        speaker,
        domain,
        remarks,
        created_at

    FROM sentence_pairs

    WHERE id = ?
");

$stmt->execute([$id]);

$row=$stmt->fetch(PDO::FETCH_ASSOC);

if(!$row){

    echo json_encode([
        "status"=>false,
        "message"=>"Sentence not found."
    ]);

    exit;

}

echo json_encode($row,JSON_UNESCAPED_UNICODE);

?>