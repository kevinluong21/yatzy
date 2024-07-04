<?php
//template used to generate the different dice faces
//these function names will be changed!
function one() {
    echo '
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
    </table>
    ';
}

function two() {
    echo '
    <table class="dice-face">
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
    </table>
    ';
}

function three() {
    echo '
    <table class="dice-face">
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
    </table>
    ';
}

function four() {
    echo '
    <table class="dice-face">
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
    </table>
    ';
}

function five() {
    echo '
    <table class="dice-face">
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
    </table>
    ';
}

function six() {
    echo '
    <table class="dice-face">
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
    </table>
    ';
}

function generateFace($i) {
    switch ($i) {
        case 1:
            one();
            break;
        case 2:
            two();
            break;
        case 3:
            three();
            break;
        case 4:
            four();
            break;
        case 5:
            five();
            break;
        case 6:
            six();
            break;
    }
}

?>