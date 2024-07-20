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

//build a table of all the rounds that the user has played
function displayAllGames(games) {
    var popup = document.getElementsByClassName("popup")[0];
    var gamesTable = document.createElement("table");
    gamesTable.classList.add("games-table");
    var gamesLen = 10;

    games.sort(function(a, b){return b - a}); //sort by score (highest score is first)

    if (games.length < 10) { //only display the top 10 scores
        gamesLen = games.length;
    }

    games = games.slice(0, gamesLen); //take the top 10 scores (if less than 10, take all of them)

    for (let i = 0; i < games.length; i++) {
        var row = document.createElement("tr");

        var rowNum = document.createElement("td");
        rowNum.innerHTML = "Game " + String(i + 1);

        var result = document.createElement("td");
        result.innerHTML = games[i];

        row.appendChild(rowNum);
        row.appendChild(result);
        gamesTable.appendChild(row);
        
        popup.replaceChild(gamesTable, popup.children[2]); //replace the original table with the new table
    }
}

function generatePlayArea() {
    document.getElementsByClassName("play-area")[0].innerHTML = `
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
            <button onclick="roll()">Re-roll</button>
        </div>
    `
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
                var games = response["games"];
                var gameOver = response["gameOver"];

                if (newRound) {
                    addRound(numRounds); //add a new row of dice for the new round
                }

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

                if (gameOver) {
                    show("endingScreen");
                    displayAllGames(games);
                }
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
    // var xhttp = new XMLHttpRequest();
    // xhttp.open("POST", "app/models/session.php", true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.send("action=rollDice");
    // update(); //update the page

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                var response = JSON.parse(xmlhttp.responseText);
                var face = response["value"];

                for (let i = 0; i < face.length; i++) {
                    dice[i].innerHTML = generateFace(face[i]);
                }
            }
        }
    };

    xmlhttp.open("GET", "/api.php?action=roll", true);
    xmlhttp.send();
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

function playAgain() {
    hide("endingScreen");
    generatePlayArea();
    
    const buttons = document.querySelectorAll('button');

    console.log(buttons);

    buttons.forEach(button => {
        button.removeAttribute("disabled");
    });

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "app/models/session.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=playAgain");
    update(); //update the page
}

function show(popup) {
    document.getElementById(popup).style.display = "block";
}

function hide(popup) {
    document.getElementById(popup).style.display = "none";
}

//onload, display all the rolled dice
window.onload = update();