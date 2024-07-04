<?php
namespace Yatzy;

require "Dice.php";

use Yatzy\Dice;
use Error;

class YatzyGame {
    private $round;
    private $diceValues;
    private $diceStatus;

    public function __construct() {
        $this->round = 0;

        $this->diceValues = array_fill(0, 5, 0);
        
        $this->diceStatus = array_fill(0, 5, false);
    }

    public function rollDice(){ 
        if($this->round == 3){ 
            throw new Error("On maximum number of rolls for turn");
        }

        $d = new Dice();

        $i = 0;
        while ($i < 5) {
            if(!$this->diceStatus[$i]){ //only roll the dice that have a "true" status
                $this->diceValues[$i] = $d->roll();
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