<?php
//used to return values from the session

require "YatzyGame.php";
require "YatzyEngine.php";

use Yatzy\YatzyGame;
use Yatzy\YatzyEngine;

session_start(); //connect to session

$scoreCategories = ["ones", "twos", "threes", "fours", "fives", "sixes", "one_pair", "two_pairs", "three_of_a_kind", "four_of_a_kind",
"small_straight", "large_straight", "full_house", "chance", "yatzy"];

function calculatePointsToEarn() {
    $pointsToEarn = [];
    $game = $_SESSION["game"];
    $engine = $_SESSION["engine"];

    foreach ($GLOBALS["scoreCategories"] as $category) {
        $pointsToEarn[] = array_sum($engine -> turnScore($game, [], $category)); //return the sum of the scores (only either the 
        //upper or lower scores can be greater than 0, so adding them together will just give the score of the upper or lower scores)
    }

    return $pointsToEarn;
}

function addRound() { //start a new round by resetting the dice
    $game = $_SESSION["game"];
    $game -> incrementNumRounds(); //increment to indicate a new round has started
    $game -> resetGame(); //resets for a new round (number of rolls) but maintains the original state
    $game -> rollDice(); //roll the dice once a new round starts
    $_SESSION["game"] = $game;
}

function playAgain() {
    //restart the entire game
    $game = new YatzyGame();
    $game -> rollDice(); //on game start, roll the dice
    $engine = new YatzyEngine();

    $_SESSION["game"] = $game; //store the game object to the session
    $_SESSION["engine"] = $engine; //store the engine object to the session
    $_SESSION["categoriesPlayed"] = []; //store all of the categories that the player selects
    $_SESSION["totalScore"] = 0;
    $_SESSION["upperScore"] = 0;
    $_SESSION["newRound"] = false; //flag to check if a new round has started
}

$response = [];

if (!isset($_SESSION["game"]) || !isset($_SESSION["engine"])) {
    throw new Exception("Game or engine is not initialized. No data to return.");
}

if (isset($_POST["action"]) && $_POST["action"] == "getGameStatus") { //remember to update to check if the rest are also set!
    $response["newRound"] = $_SESSION["newRound"];

    if ($_SESSION["newRound"] && !$_SESSION["gameOver"]) {
        addRound();
        $_SESSION["newRound"] = false; //reset the flag if it was true
    }

    $response["diceValues"] = $_SESSION["game"] -> getAllDiceValues();
    //change to return ALL of the arrays so that the JS can index for the correct round without having to return multiple versions!
    $response["diceStatus"] = $_SESSION["game"] -> getAllDiceStatus();
    $response["categoriesPlayed"] = $_SESSION["categoriesPlayed"];
    $response["totalScore"] = $_SESSION["engine"] -> getTotalScore();
    $response["upperScore"] = $_SESSION["engine"] -> getUpperScore();
    $response["rolls"] = $_SESSION["game"] -> getNumRolls();
    $response["pointsToEarn"] = calculatePointsToEarn();
    $response["numRounds"] = $_SESSION["game"] -> getNumRounds();
    $response["games"] = $_SESSION["games"];
    $response["gameOver"] = $_SESSION["gameOver"];
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

        $scores = $engine -> turnScore($game, $categoriesPlayed, $scoreCategory);
        $engine -> addUpperScore($scores[0]);
        $engine -> addLowerScore($scores[1]);
        $_SESSION["totalScore"] = $engine -> getTotalScore();
        $_SESSION["upperScore"] = $engine -> getUpperScore();
        $categoriesPlayed[] = $scoreCategory;
        $game -> keepAllDice(); //once a category is picked, all dice are automatically kept (locked from re-rolling)

        $_SESSION["newRound"] = true; //flag to indicate that a new round has started

        $_SESSION["game"] = $game;
        $_SESSION["engine"] = $engine;
        $_SESSION["categoriesPlayed"] = $categoriesPlayed;

        if ($game -> getNumRounds() == 15) { //game is over!
            //once the game is over, add the game score to the list
            $_SESSION["games"][] = $_SESSION["game"] -> getTotalScore();
            $_SESSION["gameOver"] = true;
            $_SESSION["newRound"] = false;
        }
    }
    catch (Exception $e) {
        echo $e; //make sure to display error message here!!!
    }
}

header("Content-Type: application/json");
echo json_encode($response);
?>