var dice = document.getElementsByClassName("dice");

function addRound(roundNum) {
    var playArea = document.getElementsByClassName("play-area")[0];
    var round = document.createElement("div");
    round.className = "round";

    round.innerHTML = `
    <h1>Round <span class="round-number">${roundNum}</span></h1>
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
    `;

    playArea.appendChild(round);
}

function generateFace(face) {
    switch (face) {
        case 1:
            return `
            <table class="dice-face">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>`;
        case 2:
            return `<table class="dice-face">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>`;
        case 3:
            return `<table class="dice-face">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td><div class="dice-dot"></div></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>`;
        case 4:
            return `<table class="dice-face">
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
            </table>`;
        case 5:
            return `<table class="dice-face">
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                </tr>
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
            </table>`;
        case 6:
            return `<table class="dice-face">
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td><div class="dice-dot"></div></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><div class="dice-dot"></div></td>
                    <td><div class="dice-dot"></div></td>
                    <td><div class="dice-dot"></div></td>
                </tr>
            </table>`;
    }
}

//used to update the page whenever there is a change in the server
function update() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                console.log(this.responseText);
                var response = JSON.parse(this.responseText);
                var face = response["diceValues"];
                var status = response["diceStatus"];
                var categoriesPlayed = response["categoriesPlayed"];
                var totalScore = response["totalScore"];
                var upperScore = response["upperScore"];
                var rollsLeft = 3 - response["rolls"];
                var numRounds = response["numRounds"];
                var pointsToEarn = response["pointsToEarn"];
                var newRound = response["newRound"];

                console.log(response);

                if (newRound) {
                    addRound(numRounds); //add a new row of dice for the new round
                }

                console.log(numRounds);

                for (let i = 0; i < numRounds; i++) {
                    for (let j = 0; j < face[i].length; j++) {
                        dice[(i * 5) + j].innerHTML = generateFace(face[i][j]);
                        if (status[i][j]) {
                            dice[(i * 5) + j].style.backgroundColor = "#A5DD9B";
                        }
                    }
                }

                for (let i = 0; i < categoriesPlayed.length; i++) {
                    document.getElementById(categoriesPlayed[i]).setAttribute("disabled", true);
                }

                for (let i = 0; i < pointsToEarn.length; i++) {
                    document.getElementsByClassName("points-to-earn")[i].innerHTML = pointsToEarn[i];
                }

                document.getElementById("total-score").innerHTML = totalScore;
                document.getElementById("upper-score").innerHTML = upperScore;
                document.getElementById("rolls").innerHTML = rollsLeft;
            }
            catch (error) {
                console.log("Ran into an error while updating:", error);
            }
        }
    };

    xhttp.open("POST", "app/models/session.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=getGameStatus");
}

//roll all the dice with a status of false
function roll() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "app/models/session.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=rollDice");
    update(); //update the page
}

function keep(i) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "app/models/session.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=setDiceStatus&index=" + String(i));
    update(); //update the page
}

function submitScoreCategory(category) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "app/models/session.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=submitScoreCategory&category=" + category);
    update(); //update the page
}

//onload, display all the rolled dice
window.onload = update();