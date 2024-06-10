import Dice from './dice.js';

var yatzyGame = (function() {
    var roll = 0;
    var diceValues = [0, 0, 0, 0, 0];
    var diceKeepState = [false, false, false, false, false];
    var dice = Dice.create(6);

    // Roll the dice, depending on the roll and keep/re-roll state of the dice
    function rollDice() { 
        if(this.roll == 3){ // When on maximum roll
            throw new Error("On maximum number of rolls for turn");
        }

        for(var i=0;i<this.diceValues.length;i++){
            if(!this.diceKeepState[i]){
                this.diceValues[i] = dice.roll();
            }
        }
        this.roll++;
    }

    // Keep state of the dice
    function keepDice(i) {
        this.diceKeepState[i] = true;
    }

    // Reroll state of the dice
    function rerollDice(i) { 
        this.diceKeepState[i] = false;
    }

    // Reset the game
    function resetGame(){ 
        this.roll = 0;
        this.diceValues = [0, 0, 0, 0, 0];
        this.diceKeepState = [false, false, false, false, false];
    }

    return yatzyGame;
} ());