<?php
//used to return values from the session

require "YatzyGame.php";
require "YatzyEngine.php";

session_start(); //connect to session

$response = [];

if (!isset($_SESSION["game"]) || !isset($_SESSION["engine"])) {
    throw new Exception("Game or engine is not initialized. No data to return.");
}

if (isset($_POST["action"]) && $_POST["action"] == "getGameStatus") {
    $response["diceValues"] = $_SESSION["game"] -> getDiceValues();
    $response["diceStatus"] = $_SESSION["game"] -> getDiceStatus();
    $response["scoreCategories"] = $_SESSION["categories"];
    $response["totalScore"] = $_SESSION["totalScore"];
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

if (isset($_POST["action"]) && isset($_POST["category"]) && $_POST["action"] == "submitScoreCategory") {
    try {
        $game = $_SESSION["game"];
        $engine = $_SESSION["engine"];
        $categoriesPlayed = $_SESSION["categories"];
        $scoreCategory = $_POST["category"];

        $_SESSION["totalScore"] = $engine -> turnScore($game, $categoriesPlayed, $scoreCategory);
        $categoriesPlayed[] = $scoreCategory;

        $_SESSION["game"] = $game;
        $_SESSION["engine"] = $engine;
        $_SESSION["categories"] = $categoriesPlayed;
    }
    catch (Exception $e) {
        echo $e;
    }
}

header("Content-Type: application/json");
echo json_encode($response);
?>