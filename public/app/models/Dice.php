<?php
class Dice {

    //default constructor
    function _construct() {
    }

    function roll() {
        return rand(0, 6); //assume a die always has 6 sides
    }
}
?>