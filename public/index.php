<?php
require_once('_config.php');

use YatzyGame;

$game = new YatzyGame();

echo "{$game->getRound()}<br>";

foreach ($game->getDiceValues() as $val) {
    echo "{$val}<br>";
}

foreach ($game->getDiceStatus() as $val) {
    echo "{$val}<br>";
}
?>