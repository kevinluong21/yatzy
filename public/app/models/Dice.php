<?php
class Dice {

    //default constructor
    public function __construct() {
    }

    public function roll() {
        return rand(0, 6); //assume a die always has 6 sides
    }
}
?>