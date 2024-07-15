<?php
namespace Yatzy;

require "Dice.php";

use Yatzy\Dice;

class YatzyGame {
    private $numRolls;
    private $numRounds;
    private $dice; //a list of all dice
    private $diceValues;
    private $diceStatus;
    private $totalScore; //total score for the game (calculated in the engine)

    public function __construct() {
        $this->numRolls = 0;
        // $this->diceValues = array_fill(0, 5, 0);
        // $this->diceStatus = array_fill(0, 5, false);
        $this->totalScore = 0;
        $this->numRounds = 1;

        $this->dice = [];
        $i = 0;
        while ($i < 5) {
            $this->dice[] = new Dice();
            $i++;
        }

        $this->diceValues = [];
        $this->diceStatus = [];
        $i = 0;
        for ($i = 0; $i < 15; $i++) {
            $this->diceValues[] = array_fill(0, 5, 0);
            $this->diceStatus[] = array_fill(0, 5, false);
        }
    }

    public function rollDice(){ 
        if($this->numRolls >= 3){ //max number of rolls used, function exits
            return;
        }

        $i = 0;
        while ($i < 5) {
            if(!$this->diceStatus[$this->numRounds - 1][$i]){ //only roll the dice that have a "false" status
                $this->diceValues[$this->numRounds - 1][$i] = $this->dice[$i]->roll();
            }
            $i++;
        }
        
        //on next roll, if it uses up all 3 rolls, then it must mark all of the dice as keep
        if (++$this->numRolls == 3) {
            $this->keepAllDice();
        }
    }

    public function keepDice($i){
        $this->diceStatus[$this->numRounds - 1][$i] = true;
    }

    public function keepAllDice() {
        $i = 0;
        while ($i < 5) {
            $this->diceStatus[$this->numRounds - 1][$i] = true;
            $i++;
        }
    }

    public function rerollDice($i){
        $this->diceStatus[$this->numRounds - 1][$i] = false;
    }

    public function resetGame(){ //UPDATE!
        $this->numRolls = 0;
        // $this->diceValues = array_fill(0, 5, 0);
        // $this->diceStatus = array_fill(0, 5, false);
    }

    public function getNumRolls() {
        return $this->numRolls;
    }

    public function getDiceValues() {
        return $this->diceValues[$this->numRounds - 1]; //only return the dice values for the current round
    }

    public function getDiceStatus() {
        return $this->diceStatus[$this->numRounds - 1]; //only return the dice status for the current round
    }

    public function getAllDiceValues() {
        return $this->diceValues;
    }

    public function getAllDiceStatus() {
        return $this->diceStatus;
    }

    public function setTotalScore($score) {
        $this->totalScore = $score;
    }

    public function getTotalScore() {
        return $this->totalScore;
    }

    public function incrementNumRounds() {
        $this->numRounds++;
    }

    public function getNumRounds() {
        return $this->numRounds;
    }
}
?>