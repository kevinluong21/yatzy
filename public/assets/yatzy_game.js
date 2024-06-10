import Dice from './dice.js';

var YatzyGame = (function() {
    var game = {}
    game.roll = 0;
    game.diceValues = [0, 0, 0, 0, 0];
    game.diceKeepState = [false, false, false, false, false];

    game.dice = new Dice();
    game.dice.create(6);

    // Roll the dice, depending on the roll and keep/re-roll state of the dice
    game.rollDice = function(){ 
        if(game.roll == 3){ // When on maximum roll
            throw new Error("On maximum number of rolls for turn");
        }

        for(var i=0;i<game.diceValues.length;i++){
            if(!game.diceKeepState[i]){
                game.diceValues[i] = game.dice.roll() + 1;
            }
        }
        game.roll++;
    }

    // Keep state of the dice
    game.keepDice = function(i){
        game.diceKeepState[i] = true;
    }

    // Reroll state of the dice
    game.rerollDice = function(i){
        game.diceKeepState[i] = false;
    }

    // Reset the game
    game.resetGame = function(){
        game.roll = 0;
        game.diceValues = [0, 0, 0, 0, 0];
        game.diceKeepState = [false, false, false, false, false];
    }

    return game;
} ());

export default YatzyGame;