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

function roll(i) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

        }
    };
    dice[i].innerHTML = generateFace(face);
}

function keep(i) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

        }
    };
}

//onload set all dice faces to show 1
window.onload = function() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var response = JSON.parse(this.responseText);
                face = response["diceValues"];

                for (let i = 0; i < 5; i++) {
                    dice[i].innerHTML = generateFace(face[i]);
                }
            }
            catch (error) {
                console.log("Server-side error", error);
            }
        }
    };

    xhttp.open("POST", "app/models/session.php", true);
    xhttp.send();
};