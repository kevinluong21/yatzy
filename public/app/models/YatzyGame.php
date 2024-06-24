<?php
namespace Yatzy;

class YatzyGame {
    private $round;
    private $diceValues;
    private $diceStatus;

    public function __construct() {
        $this->round = 0;

        $this->diceValues = [];
        $i = 0;
        while ($i < 5) { //fill the array with all 0s
            $this->diceValues[] = 0;
            $i++;
        }
        
        $this->diceStatus = [];
        $i = 0;
        while ($i < 5) { //fill the array wih all "re-roll" (no value was kept yet)
            $this->diceStatus[] = "re-roll";
            $i++;
        }
    }

    public function getRound() {
        return $this->round;
    }

    public function getDiceValues() {
        return $this->diceValues;
    }

    public function getDiceStatus() {
        return $this->diceStatus;
    }
}
?>