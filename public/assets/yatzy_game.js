// In `yatzy_game.js`, implement a current state of a game.
// A yatzy game comprises of a turn, which includes

// * Which roll you are on (0, 1, 2, or 3)
// * Current value on each of the 5 dice
// * Keep / re-roll state of each dice

// The `YatzyGame` should focus on tracking the state of the game
// without knowing much about the rules, that comes next!

import Dice from './dice.js';

class YatzyGame {
    constructor(){
        this.roll = 0;
        this.diceValues = [0, 0, 0, 0, 0];
        this.diceKeepState = [false, false, false, false, false];
        this.dice = Dice.create(6);
    }

    // Roll the dice, depending on the roll and keep/re-roll state of the dice
    rollDice() { 
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
    keepDice(i) {
        this.diceKeepState[i] = true;
    }

    // Reroll state of the dice
    rerollDice(i) { 
        this.diceKeepState[i] = false;
    }

    // Reset the game
    resetGame(){ 
        this.roll = 0;
        this.diceValues = [0, 0, 0, 0, 0];
        this.diceKeepState = [false, false, false, false, false];
    }
}