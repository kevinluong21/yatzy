<?php
namespace Yatzy;

require "Dice.php";

use Yatzy\Dice;

class YatzyGame {
    private $numRounds;
    private $numRolls;
    private $dice;
    private $diceValues;
    private $diceStatus;
    private $totalScore; //total score for the game (calculated in the engine)

    public function __construct() {
        $this->numRounds = 0;
        $this->numRolls = 0;
        $this->diceValues = array_fill(0, 5, 0);
        $this->diceStatus = array_fill(0, 5, false);
        $this->totalScore = 0;

        $this->dice = [];
        $i = 0;
        while ($i < 5) {
            $this->dice[] = new Dice();
            $i++;
        }
    }

    public function rollDice(){ 
        if($this->numRolls >= 3){ //max number of rolls used, function exits
            return;
        }

        $i = 0;
        while ($i < 5) {
            if(!$this->diceStatus[$i]){ //only roll the dice that have a "true" status
                $this->diceValues[$i] = $this->dice[$i]->roll();
            }
            $i++;
        }
        
        //on next roll, if it uses up all 3 rolls, then it must mark all of the dice as keep
        if (++$this->numRolls == 3) {
            $i = 0;
            while ($i < 5) {
                $this->diceStatus[$i] = true;
                $i++;
            }
        }
    }

    public function keepDice($i){
        $this->diceStatus[$i] = true;
    }

    public function rerollDice($i){
        $this->diceStatus[$i] = false;
    }

    public function resetGame(){
        $this->numRolls = 0;
        $this->diceValues = array_fill(0, 5, 0);
        $this->diceStatus = array_fill(0, 5, false);
    }

    public function getNumRolls() {
        return $this->numRolls;
    }

    public function getDiceValues() {
        return $this->diceValues;
    }

    public function getDiceStatus() {
        return $this->diceStatus;
    }
}
?>