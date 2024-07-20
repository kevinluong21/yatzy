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
$_SESSION["categoriesPlayed"] = []; //store all of the categories that the player selects
$_SESSION["totalScore"] = 0;
$_SESSION["upperScore"] = 0;
$_SESSION["newRound"] = false; //flag to check if a new round has started
$_SESSION["games"] = [];
$_SESSION["gameOver"] = false;
$_SESSION["numGames"] = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatzy by JK</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="play-area">
        <div class="round">
            <h1>Round <span class="round-number">1</span></h1>
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
            <!-- <button onclick="roll()" id="roll">Re-roll</button> -->
            <button id="roll">Re-roll</button>
        </div>
    </div>
    <div class="scoreboard">
        <div class="scorebox">
            Your Total Score: <span id="total-score">0</span>
            <br>
            Your Upper Score: <span id="upper-score">0</span>
            <br>
            Rolls Left For This Round: <span id="rolls">0</span>
        </div>
        <table class="score-categories">
            <tr>
                <!-- upper section -->
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="ones" onclick="submitScoreCategory('ones')">Ones</button>
                        <span class="tooltip-text">
                            The sum of all dice showing the number 1.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="twos" onclick="submitScoreCategory('twos')">Twos</button>
                        <span class="tooltip-text">
                            The sum of all dice showing the number 2.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="threes" onclick="submitScoreCategory('threes')">Threes</button>
                        <span class="tooltip-text">
                            The sum of all dice showing the number 3.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="fours" onclick="submitScoreCategory('fours')">Fours</button>
                        <span class="tooltip-text">
                            The sum of all dice showing the number 4.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="fives" onclick="submitScoreCategory('fives')">Fives</button>
                        <span class="tooltip-text">
                            The sum of all dice showing the number 5.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="sixes" onclick="submitScoreCategory('sixes')">Sixes</button>
                        <span class="tooltip-text">
                            The sum of all dice showing the number 6.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <!-- lower section -->
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="one_pair" onclick="submitScoreCategory('one_pair')">One Pair</button>
                        <span class="tooltip-text">
                            Two dice showing the same number. Score: Sum of those two dice.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="two_pairs" onclick="submitScoreCategory('two_pairs')">Two Pairs</button>
                        <span class="tooltip-text">
                            Two different pairs of dice. Score: Sum of dice in those two pairs.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="three_of_a_kind" onclick="submitScoreCategory('three_of_a_kind')">Three of a Kind</button>
                        <span class="tooltip-text">
                            Three dice showing the same number. Score: Sum of those three dice.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="four_of_a_kind" onclick="submitScoreCategory('four_of_a_kind')">Four of a Kind</button>
                        <span class="tooltip-text">
                            Four dice with the same number. Score: Sum of those four dice.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="small_straight" onclick="submitScoreCategory('small_straight')">Small Straight</button>
                        <span class="tooltip-text">
                            The combination 1-2-3-4-5. Score: 15 points (sum of all the dice).<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="large_straight" onclick="submitScoreCategory('large_straight')">Large Straight</button>
                        <span class="tooltip-text">
                            The combination 2-3-4-5-6. Score: 20 points (sum of all the dice).<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="full_house" onclick="submitScoreCategory('full_house')">Full House</button>
                        <span class="tooltip-text">
                            Any set of three combined with a different pair. Score: Sum of all the dice.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="chance" onclick="submitScoreCategory('chance')">Chance</button>
                        <span class="tooltip-text">
                            Any combination of dice. Score: Sum of all the dice.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
                <td>
                    <div class="tooltip">
                        <button class="score-category" id="yatzy" onclick="submitScoreCategory('yatzy')">Yatzy</button>
                        <span class="tooltip-text">
                            All five dice with the same number. Score: 50 points.<br><br>
                            Points To Earn: <span class="points-to-earn"></span>
                        </span>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    <!-- statistics popup -->
    <div class="popup-bg" id="endingScreen">
        <div class="popup">
            <div class="close-btn" onclick='hide("endingScreen")'>&#x2715;</div>
            <h1 class="popup-title">Leaderboard</h1>
            <table class="games-table"></table>
            <div class="play-again">
                <button class="play-again-btn" onclick="playAgain()">
                    Play Again
                </button>
            </div>
        </div>
    </div>

    <script src="script.js" type="text/javascript"></script>
    <script>
        var dice = document.getElementsByClassName("dice");
        var roll = document.getElementById("roll");

        roll.onclick = async function() {
            let answer = $.ajax({
            type: "GET",
            url: "api.php?action=roll"
            }).then(function(data) {
                var face = data.value;

                for (let i = 0; i < face.length; i++) {
                    dice[i].innerHTML = generateFace(face[i]);
                }
            });
        };
    </script>
</body>
</html>