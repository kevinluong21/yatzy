<?php
//used to return values from the session

require "YatzyGame.php";

session_start(); //connect to session

$response = [];

if (isset($_SESSION["game"])) {
    $response["diceValues"] = $_SESSION["game"] -> getDiceValues();
    $response["diceStatus"] = $_SESSION["game"] -> getDiceStatus();
}

header("Content-Type: application/json");
echo json_encode($response);
?>