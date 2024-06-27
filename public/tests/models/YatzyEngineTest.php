<?php
namespace Yatzy\Test;

use Yatzy\YatzyGame;
use Yatzy\YatzyEngine;
use PHPUnit\Framework\TestCase;

class YatzyEngineTest extends TestCase
{
    public function testOnesScore()
    {
        $e = new YatzyEngine();
        $game = new YatzyGame();
        $game->diceValues = [1, 2, 1, 4, 1];
        $expectedScore = 3;
        $score = $e->turnScore($game, 'ones');
        $this->assertEquals($expectedScore, $score);
    }

    public function testFullHouseScore()
    {
        $e = new YatzyEngine();
        $game = new YatzyGame();
        $game->diceValues =  [2, 2, 3, 3, 3]; 
        $expectedScore = 25; 
        $score = $e->turnScore($game, 'full house');
        $this->assertEquals($expectedScore, $score);
    }

    public function testOverallScore()
    {
        $e = new YatzyEngine();
        $game = new YatzyGame();
        $game->totalScore = 200;
        $game->upperScore = 65;
        $game->totalScore = $e->overallScore($game);
        $expectedTotalScore = 235; // 100 + 35 (bonus if upper >= 63) = 235
        $this->assertEquals($expectedTotalScore, $this->game->overallScore($game));
    }
}
?>