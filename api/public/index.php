<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory as Appfactory;



require __DIR__ . '/../vendor/autoload.php';

$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection(parse_ini_file('../conf/db.ini')); /* configuration avec nos paramètres */
$db->setAsGlobal(); /* rendre la connexion visible dans tout le projet */
$db->bootEloquent(); /* établir la connexion */


$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world!");
  return $response;
});


$app->get('/users', api\actions\UserAction::class);

$app->run();
