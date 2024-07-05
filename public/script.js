var dice = document.getElementsByClassName("dice");

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
                var response = JSON.parse(this.responseText);
                var face = response["diceValues"];
                var status = response["diceStatus"];
                var categories = response["scoreCategories"];

                console.log(response);

                for (let i = 0; i < face.length; i++) {
                    dice[i].innerHTML = generateFace(face[i]);
                }

                for (let i = 0; i < status.length; i++) {
                    if (status[i]) {
                        dice[i].style.backgroundColor = "green";
                    }
                }

                for (let i = 0; i < categories.length; i++) {
                    document.getElementById(categories[i]).setAttribute("disabled", true);
                }
            }
            catch (error) {
                console.log("Server-side error:", error);
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