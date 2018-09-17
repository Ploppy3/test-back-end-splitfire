<?php

session_start();

require 'rest/router.php';
require '../dbConnect.php';

$router = new Router();
header("Access-Control-Allow-Origin: *");

$router->addRoute('/tweets/', new TweetsController($db));

$router->run();
