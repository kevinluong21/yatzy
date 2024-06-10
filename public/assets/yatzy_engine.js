var totalScore = 0;
var upperScore = 0;

function turnScore(game, scoreBox){
    var score = 0;

    switch(scoreBox){ // Calculate score based on score box
        case "ones":
            score = sumOfSpecificSide(game, 1);
            upperScore += score;
            break;
        case "twos":
            score = sumOfSpecificSide(game, 2);
            upperScore += score;
            break;
        case "threes":
            score = sumOfSpecificSide(game, 3);
            upperScore += score;
            break;
        case "fours":
            score = sumOfSpecificSide(game, 4);
            upperScore += score;
            break;
        case "fives":
            score = sumOfSpecificSide(game, 5);
            upperScore += score;
            break;
        case "sixes":
            score = sumOfSpecificSide(game, 6);
            upperScore += score;
            break;
        case "three of a kind":
            score = sumOfAllDice(game);
            break;
        case "four of a kind":
            score = sumOfAllDice(game);
            break;
        case "full house":
            score = 25;
            break;
        case "small straight":
            score = 30;
            break;
        case "large straight":
            score = 40;
            break;
        case "yahtzee":
            score = 50;
            break;
        case "chance":
            score = sumOfAllDice(game);
            break;
    }

    totalScore += score;
    return score;
}

function overallScore(game){
    var bonus = 0;
    if(upperScore >= 63){
        bonus = 35;
    }

    return totalScore + bonus;
}

function sumOfSpecificSide(game, side){
    var sum = 0;
    for (var i=0;i<game.diceValues.length;i++) {
        if(game.diceValues[i] == side){ // If the dice matches the side given add to sum
            sum += game.diceValues[i];
        }
    }
    return sum;
}

function sumOfAllDice(game){
    var sum = 0;
    for (var i=0;i<game.diceValues.length;i++) {
        sum += game.diceValues[i];
    }
    return sum;
}