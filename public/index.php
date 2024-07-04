<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatzy by JK</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="play-area">
        <table class="die">
            <tr>
                <th colspan="5">Round 1</th>
            </tr>
            <tr>
                <td>
                    <div class="dice">
                    <!-- to import a php file, only use require once -->
                        <?php require 'app/views/DiceFace.php';
                            generateFace(1);
                        ?>
                    </div>
                </td>
                <td>
                    <div class="dice">
                        <?php
                            generateFace(1);
                        ?>
                    </div>
                </td>
                <td>
                    <div class="dice">
                        <?php
                            generateFace(1);
                        ?>
                    </div>
                </td>
                <td>
                    <div class="dice">
                        <?php
                            generateFace(1);
                        ?>
                    </div>
                </td>
                <td>
                    <div class="dice">
                        <?php
                            generateFace(1);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="scoreboard">
        <ul>
            <li>Ones: The sum of all dice showing the number 1.</li>
            <li>Twos: The sum of all dice showing the number 2.</li>
            <li>Threes: The sum of all dice showing the number 3.</li>
            <li>Fours: The sum of all dice showing the number 4.</li>
            <li>Fives: The sum of all dice showing the number 5.</li>
            <li>Sixes: The sum of all dice showing the number 6.</li>
            <li>One Pair: Two dice showing the same number. Score: Sum of those two dice.</li>
            <li>Two Pairs: Two different pairs of dice. Score: Sum of dice in those two pairs.</li>
            <li>Three of a Kind: Three dice showing the same number. Score: Sum of those three dice.</li>
            <li>Four of a Kind: Four dice with the same number. Score: Sum of those four dice.</li>
            <li>Small Straight: The combination 1-2-3-4-5. Score: 15 points (sum of all the dice).</li>
            <li>Large Straight: The combination 2-3-4-5-6. Score: 20 points (sum of all the dice).</li>
            <li>Full House: Any set of three combined with a different pair. Score: Sum of all the dice.</li>
            <li>Chance: Any combination of dice. Score: Sum of all the dice.</li>
            <li>Yatzy: All five dice with the same number. Score: 50 points.</li>
          </ul>          
    </div>
</body>
</html>