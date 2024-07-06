<?php
namespace Yatzy;

use Exception;

class YatzyEngine {
    private $totalScore;
    private $upperScore;
    const BONUS = 35; //declare a constant for the bonus

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

    public function sumOfDuplicates($game, $numDuplicates, $groupsOfDuplicates = 1) {
        //numDuplicates is how many duplicate values (e.g. 2 is a pair)
        //groupsOfDuplicates is how many different duplicate values are summed together (e.g. 2 pairs means 2 groups of duplicates)
        $sum = 0;
        $values = $game -> getDiceValues();

        $frequency = array_count_values($values);
        krsort($frequency, SORT_NUMERIC); //sort the keys of count in descending order

        $frequency = array_filter($frequency, function($count) use ($numDuplicates) { //filter all values that appear at least numDuplicates times
            return $count >= $numDuplicates;
        });

        if (count($frequency) < $groupsOfDuplicates) {
            return 0;
        }

        //since the array is already sorted in reverse order, the head is the highest duplicate sum
        foreach ($frequency as $index => $value) {
            if ($groupsOfDuplicates == 0) {
                break;
            }
            $sum += $index * $numDuplicates;
            $groupsOfDuplicates--;
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

    public function getTotalScore() {
        if ($this->upperScore >= 63) {
            return $this->totalScore + self::BONUS;
        }

        return $this->totalScore;
    }

    public function turnScore($game, $categoriesPlayed, $scoreCategory) {
        //if the user already played this category, throw an exception
        if (in_array($scoreCategory, $categoriesPlayed)) {
            throw new Exception("Category already played.");
        }

        $score = 0;

        switch ($scoreCategory) { // Calculate score based on score category
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
            case "one_pair":
                $score = $this->sumOfDuplicates($game, 2);
                break;
            case "two_pairs":
                $score = $this->sumOfDuplicates($game, 2, 2);
                break;
            case "three_of_a_kind":
                $score = $this->sumOfDuplicates($game, 3);
                break;
            case "four_of_a_kind":
                $score = $this->sumOfDuplicates($game, 4);
                break;
            case "full_house":
                $values = $game -> getDiceValues();
                $frequency = array_count_values($values); //count the number of duplicates for each value

                if (in_array(3, $frequency) && in_array(2, $frequency)) { //if there exists a group of 3 duplicates and 2 duplicates
                    $score = $this->sumOfAllDice($game);
                }
                break;
            case "small_straight":
                $values = $game -> getDiceValues();
                sort($values);
                if ($values == [1, 2, 3, 4, 5]) { //same values regardless of order
                    $score = 15;
                }
                break;
            case "large_straight":
                $values = $game -> getDiceValues();
                sort($values);
                if ($values == [2, 3, 4, 5, 6]) { //same values regardless of order
                    $score = 20;
                }
                break;
            case "yatzy":
                $score = $this->sumOfDuplicates($game, 5);
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