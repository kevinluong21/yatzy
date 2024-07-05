<?php
require "app/models/YatzyGame.php";
require "app/models/YatzyEngine.php";

use Yatzy\YatzyGame;
use Yatzy\YatzyEngine;

session_start();
$game = new YatzyGame();
$game -> rollDice(); //on game start, roll the dice
$engine = new YatzyEngine();
$_SESSION["game"] = $game; //store the game object to the session
$_SESSION["engine"] = $engine; //store the engine object to the session
$_SESSION["categories"] = []; //store all of the categories that the player selects
$_SESSION["totalScore"] = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatzy by JK</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="play-area">
        <div class="round">
            <h1>Round 1</h1>
            <table class="gameboard">
                <tr>
                    <td>
                        <div class="dice"></div>
                        <button onclick="keep(0)">Keep</button>
                    </td>
                    <td>
                        <div class="dice"></div>
                        <button onclick="keep(1)">Keep</button>
                    </td>
                    <td>
                        <div class="dice"></div>
                        <button onclick="keep(2)">Keep</button>
                    </td>
                    <td>
                        <div class="dice"></div>
                        <button onclick="keep(3)">Keep</button>
                    </td>
                    <td>
                        <div class="dice"></div>
                        <button onclick="keep(4)">Keep</button>
                    </td>
                </tr>
            </table>
            <button onclick="roll()">Re-roll</button>
        </div>
    </div>
    <div class="scoreboard">
        <div class="scorebox">
            Your Score: <span id="score"></span>
        </div>
        <table class="score-categories">
            <tr>
                <td>
                    <button id="ones" onclick="submitScoreCategory('ones')">Ones: The sum of all dice showing the number 1.</button>
                </td>
                <td>
                    <button id="twos" onclick="submitScoreCategory('twos')">Twos: The sum of all dice showing the number 2.</button>
                </td>
                <td>
                    <button id="threes" onclick="submitScoreCategory('threes')">Threes: The sum of all dice showing the number 3.</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="fours" onclick="submitScoreCategory('fours')">Fours: The sum of all dice showing the number 4.</button>
                </td>
                <td>
                    <button id="fives" onclick="submitScoreCategory('fives')">Fives: The sum of all dice showing the number 5.</button>
                </td>
                <td>
                    <button id="sixes" onclick="submitScoreCategory('sixes')">Sixes: The sum of all dice showing the number 6.</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="one_pair" onclick="submitScoreCategory('one_pair')">One Pair: Two dice showing the same number. Score: Sum of those two dice.</button>
                </td>
                <td>
                    <button id="two_pairs" onclick="submitScoreCategory('two_pairs')">Two Pairs: Two different pairs of dice. Score: Sum of dice in those two pairs.</button>
                </td>
                <td>
                    <button id="three_of_a_kind" onclick="submitScoreCategory('three_of_a_kind')">Three of a Kind: Three dice showing the same number. Score: Sum of those three dice.</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="four_of_a_kind" onclick="submitScoreCategory('four_of_a_kind')">Four of a Kind: Four dice with the same number. Score: Sum of those four dice.</button>
                </td>
                <td>
                    <button id="small_straight" onclick="submitScoreCategory('small_straight')">Small Straight: The combination 1-2-3-4-5. Score: 15 points (sum of all the dice).</button>
                </td>
                <td>
                    <button id="large_straight" onclick="submitScoreCategory('large_straight')">Large Straight: The combination 2-3-4-5-6. Score: 20 points (sum of all the dice).</button>
                </td>
            </tr>
            <tr>
                <td>
                    <button id="full_house" onclick="submitScoreCategory('full_house')">Full House: Any set of three combined with a different pair. Score: Sum of all the dice.</button>
                </td>
                <td>
                    <button id="chance" onclick="submitScoreCategory('chance')">Chance: Any combination of dice. Score: Sum of all the dice.</button>
                </td>
                <td>
                    <button id="yatzy" onclick="submitScoreCategory('yatzy')">Yatzy: All five dice with the same number. Score: 50 points.</button>
                </td>
            </tr>
        </table>
    </div>

    <script src="script.js" type="text/javascript"></script>
</body>
</html>