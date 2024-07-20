<?php
require "app/models/YatzyGame.php";
require "app/models/YatzyEngine.php";

require_once('_config.php');

use Yatzy\YatzyGame;
use Yatzy\YatzyEngine;
use Yatzy\Dice;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

session_start();

function jsonReply(Response $response, $data)
{
    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
}

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
    $data = ["version" => "1.0"];
    return jsonReply($response, $data);
});

$app->get('/api/roll', function (Request $request, Response $response, $args) {
    $d = new Dice();
    $die = [];
    for ($i = 0; $i < 5; $i++) {
        $die[] = $d->roll();
    }
    return jsonReply($response, $die);
});

$app->run();
?>