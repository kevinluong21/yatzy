<?php
//used to return values from the session

require "YatzyGame.php";
require "YatzyEngine.php";

session_start(); //connect to session

$scoreCategories = ["ones", "twos", "threes", "fours", "fives", "sixes", "one_pair", "two_pairs", "three_of_a_kind", "four_of_a_kind",
"small_straight", "large_straight", "full_house", "chance", "yatzy"];

function calculatePointsToEarn() {
    $pointsToEarn = [];
    $game = $_SESSION["game"];
    $engine = $_SESSION["engine"];

    foreach ($GLOBALS["scoreCategories"] as $category) {
        $pointsToEarn[] = $engine -> turnScore($game, [], $category);
    }

    return $pointsToEarn;
}

$response = [];

if (!isset($_SESSION["game"]) || !isset($_SESSION["engine"])) {
    throw new Exception("Game or engine is not initialized. No data to return.");
}

if (isset($_POST["action"]) && $_POST["action"] == "getGameStatus") { //remember to update to check if the rest are also set!
    $response["diceValues"] = $_SESSION["game"] -> getDiceValues();
    $response["diceStatus"] = $_SESSION["game"] -> getDiceStatus();
    $response["categoriesPlayed"] = $_SESSION["categoriesPlayed"];
    $response["totalScore"] = $_SESSION["totalScore"];
    $response["rolls"] = $_SESSION["game"] -> getNumRolls();
    $response["numRounds"] = $_SESSION["numRounds"];
    $response["pointsToEarn"] = calculatePointsToEarn();
    $response["newRound"] = $_SESSION["newRound"];

    $_SESSION["newRound"] = false; //reset the flag if it was true
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
        $categoriesPlayed = $_SESSION["categoriesPlayed"];
        $numRounds = $_SESSION["numRounds"];
        $scoreCategory = $_POST["category"];

        $_SESSION["totalScore"] = $engine -> turnScore($game, $categoriesPlayed, $scoreCategory);
        $categoriesPlayed[] = $scoreCategory;
        $game -> keepAllDice(); //once a category is picked, all dice are automatically kept (lcoked from re-rolling)
        $_SESSION["numRounds"]++; //once a score category is picked, the next round starts
        $_SESSION["newRound"] = true; //flag to indicate that a new round has started

        $_SESSION["game"] = $game;
        $_SESSION["engine"] = $engine;
        $_SESSION["categoriesPlayed"] = $categoriesPlayed;
    }
    catch (Exception $e) {
        echo $e;
    }
}

header("Content-Type: application/json");
echo json_encode($response);
?>