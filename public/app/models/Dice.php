<?php
namespace Yatzy;

class Dice {
    private $min;
    private $max;

    public function __construct($min = 1, $max = 6) { //default min is 1 and max is 6
        $this->min = $min;
        $this->max = $max;
    }

    public function roll() {
        return rand($this->min, $this->max);
    }
}
?>