<?php
namespace Yatzy;

class YatzyEngine {
    private $totalScore;
    private $upperScore;

    public function __construct() {
        $this->totalScore = 0;
        $this->upperScore = 0;
    }

    public function sumOfSpecificSide($game, $side) {
        $sum = 0;
        foreach ($game->getDiceValues() as $val) {
            if ($val == $side) {
                $sum += $val;
            }
        }
        return $sum;
    }

    public function sumOfAllDice($game) {
        $sum = 0;
        foreach ($game->getDiceValues() as $val) {
            $sum += $val;
        }
        return $sum;
    }

    public function overallScore($game) {
        $bonus = 0;
        if ($this->upperScore >= 63) {
            $bonus = 35;
        }

        return $this->totalScore + $bonus;
    }

    public function turnScore($game, $scoreBox) {
        $score = 0;

        switch ($scoreBox) { // Calculate score based on score box
            case "ones":
                $score = $this->sumOfSpecificSide($game, 1);
                $this->upperScore += $score;
                break;
            case "twos":
                $score = $this->sumOfSpecificSide($game, 2);
                $this->upperScore += $score;
                break;
            case "threes":
                $score = $this->sumOfSpecificSide($game, 3);
                $this->upperScore += $score;
                break;
            case "fours":
                $score = $this->sumOfSpecificSide($game, 4);
                $this->upperScore += $score;
                break;
            case "fives":
                $score = $this->sumOfSpecificSide($game, 5);
                $this->upperScore += $score;
                break;
            case "sixes":
                $score = $this->sumOfSpecificSide($game, 6);
                $this->upperScore += $score;
                break;
            case "three of a kind":
                $score = $this->sumOfAllDice($game);
                break;
            case "four of a kind":
                $score = $this->sumOfAllDice($game);
                break;
            case "full house":
                $score = 25;
                break;
            case "small straight":
                $score = 30;
                break;
            case "large straight":
                $score = 40;
                break;
            case "yahtzee":
                $score = 50;
                break;
            case "chance":
                $score = $this->sumOfAllDice($game);
                break;
        }

        $this->totalScore += $score;
        return $score;
    }
}
?>