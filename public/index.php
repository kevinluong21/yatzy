<?php
require "app/models/YatzyGame.php";
use Yatzy\YatzyGame;

session_start();
$game = new YatzyGame();
$game -> rollDice(); //on game start, roll the dice
$_SESSION["game"] = $game;

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
        <table class="gameboard">
            <tr>
                <th colspan="5">Round 1</th>
            </tr>
            <tr>
                <td>
                    <div class="dice"></div>
                    <button>Keep</button>
                </td>
                <td>
                    <div class="dice"></div>
                    <button>Keep</button>
                </td>
                <td>
                    <div class="dice"></div>
                    <button>Keep</button>
                </td>
                <td>
                    <div class="dice"></div>
                    <button>Keep</button>
                </td>
                <td>
                    <div class="dice"></div>
                    <button>Keep</button>
                </td>
            </tr>
        </table>
    </div>
    <div class="scoreboard">
        <div class="score"></div>
        <table class="score-categories">
            <tr>
                <td>
                    <button>Ones: The sum of all dice showing the number 1.</button>
                </td>
                <td>
                    <button>Twos: The sum of all dice showing the number 2.</button>
                </td>
                <td>
                    <button>Threes: The sum of all dice showing the number 3.</button>
                </td>
            </tr>

            <tr>
                <td>
                    <button>Fours: The sum of all dice showing the number 4.</button>
                </td>
                <td>
                    <button>Fives: The sum of all dice showing the number 5.</button>
                </td>
                <td>
                    <button>Sixes: The sum of all dice showing the number 6.</button>
                </td>
            </tr>

            <tr>
                <td>
                    <button>One Pair: Two dice showing the same number. Score: Sum of those two dice.</button>
                </td>
                <td>
                    <button>Two Pairs: Two different pairs of dice. Score: Sum of dice in those two pairs.</button>
                </td>
                <td>
                    <button>Three of a Kind: Three dice showing the same number. Score: Sum of those three dice.</button>
                </td>
            </tr>

            <tr>
                <td>
                    <button>Four of a Kind: Four dice with the same number. Score: Sum of those four dice.</button>
                </td>
                <td>
                    <button>Small Straight: The combination 1-2-3-4-5. Score: 15 points (sum of all the dice).</button>
                </td>
                <td>
                    <button>Large Straight: The combination 2-3-4-5-6. Score: 20 points (sum of all the dice).</button>
                </td>
            </tr>

            <tr>
                <td>
                    <button>Full House: Any set of three combined with a different pair. Score: Sum of all the dice.</button>
                </td>
                <td>
                    <button>Chance: Any combination of dice. Score: Sum of all the dice.</button>
                </td>
                <td>
                    <button>Yatzy: All five dice with the same number. Score: 50 points.</button>
                </td>
            </tr>
        </table>   
    </div>

    <script src="script.js" type="text/javascript"></script>
</body>
</html>