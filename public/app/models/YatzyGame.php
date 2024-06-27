<?php
namespace Yatzy;
Use Dice;

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

    public function rollDice(){ 
        if($this->round == 3){ 
            throw new Error("On maximum number of rolls for turn");
        }

        $d = new Dice();

        $i = 0;
        while ($i < 5) {
            if($this->diceStatus[i]){
                $this->diceValues[i] = $d->roll()+1;
            }
            $i++;
        }
        $this->round += 1;
    }

    public function keepDice($i){
        $this->diceStatus[$i] = true;
    }

    public function rerollDice($i){
        $this->diceStatus[$i] = false;
    }

    public function resetGame(){
        $this->round = 0;
        $this->diceValues = [0, 0, 0, 0, 0];
        $this->diceStatus = [false, false, false, false, false];
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