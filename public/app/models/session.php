<?php
//used to return values from the session

require "YatzyGame.php";

session_start(); //connect to session

$response = [];

if (!isset($_SESSION["game"])) {
    throw new Exception("Game is not initialized. No data to return.");
}

if (isset($_POST["action"]) && $_POST["action"] == "getGameStatus") {
    $response["diceValues"] = $_SESSION["game"] -> getDiceValues();
    $response["diceStatus"] = $_SESSION["game"] -> getDiceStatus();
}

if (isset($_POST["action"]) && $_POST["action"] == "rollDice") { //roll all dice that have a status of false
    $game = $_SESSION["game"];
    $game -> rollDice();
    $_SESSION["game"] = $game;
}

if (isset($_POST["action"]) && isset($_POST["index"]) && $_POST["action"] == "setDiceStatus") { //set dice status to true if the user
    //wants to keep the value for the dice
    $game = $_SESSION["game"];
    $game -> keepDice($_POST["index"]);
    $_SESSION["game"] = $game;
}

header("Content-Type: application/json");
echo json_encode($response);
?>