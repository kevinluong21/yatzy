var Dice = (function() {
    var dice = {};
    dice.sides;

    dice.create = function(sides) {
        dice.sides = sides; //set the number of sides for the dice
    }

    dice.roll = function() {
        return Math.floor(Math.random() * dice.sides);
    }

    return dice;
});