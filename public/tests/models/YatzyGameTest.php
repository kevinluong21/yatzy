<?php
namespace Yatzy\Test;

use Yatzy\YatzyGame;
use PHPUnit\Framework\TestCase;

class YatzyGameTest extends TestCase
{
    public function testKeepDice() {
        $game = new YatzyGame();
        $game->keepDice(0);
        $game->rollDice(); 
        $this->assertEquals(0, $game->getDiceValues()[0]);
    }

    public function testResetGame() {
        $game = new YatzyGame();
        $game->rollDice();
        $game->resetGame();
        $this->assertEquals(0, $game->getRound()); 
        $this->assertEquals([0, 0, 0, 0, 0], $game->getDiceValues()); 
        $this->assertEquals([false, false, false, false, false], $game->getDiceStatus()); 
    }
}
?>