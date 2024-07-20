<?php
require "app/models/YatzyGame.php";
require "app/models/YatzyEngine.php";

require_once('_config.php');

use Yatzy\YatzyGame;
use Yatzy\YatzyEngine;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

session_start();

$app = AppFactory::create();

$game = new YatzyGame();
$game -> rollDice(); //on game start, roll the dice
$engine = new YatzyEngine();

$_SESSION["game"] = $game; //store the game object to the session
$_SESSION["engine"] = $engine; //store the engine object to the session
$_SESSION["categoriesPlayed"] = []; //store all of the categories that the player selects
$_SESSION["totalScore"] = 0;
$_SESSION["upperScore"] = 0;
$_SESSION["newRound"] = false; //flag to check if a new round has started
$_SESSION["games"] = [];
$_SESSION["gameOver"] = false;
$_SESSION["numGames"] = 1;

$app->get('/', function (Request $request, Response $response, $args) {
    $view = file_get_contents("{$GLOBALS["appDir"]}/views/index.html");
    $response->getBody()->write($view);
    return $response;
});

$app->get('/api/version', function (Request $request, Response $response, $args) {
    // fill me in
});

$app->get('/api/roll', function (Request $request, Response $response, $args) {
    // fill me in
});

$app->run();
?>