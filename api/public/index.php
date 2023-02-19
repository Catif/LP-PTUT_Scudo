<?php

declare(strict_types=1);

use api\actions as actions;
use api\services\utils\FormatterAPI;

use Slim\Factory\AppFactory as Appfactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection($conf); /* configuration avec nos paramètres */
$db->setAsGlobal(); /* rendre la connexion visible dans tout le projet */
$db->bootEloquent(); /* établir la connexion */


$app = AppFactory::create();
$app->addRoutingMiddleware();

// Default route
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world!");

  return $response;
});


// List des routes => https://docs.google.com/document/d/1DWMMHJNmhXVq-R11X4dQVAwZPHYrf-PKavtw7hfs0_Q/edit#
// =====================
//        User
// =====================
// GET
$app->get('/api/users', actions\user\GET\UserAction::class); // OK
$app->get('/api/user/{id}', actions\user\GET\UserByIdAction::class);  // ok

// POST
$app->post('/api/register', actions\user\POST\RegisterAction::class);
$app->post('/api/login', actions\user\POST\LoginAction::class);


// PATCH


// =====================
//     Conversation
// =====================
// GET
$app->get('/api/conversations', actions\conversation\GET\ConversationAction::class); // Ok

// POST



// PATCH



// =====================
//     Message
// =====================
// POST
$app->post('/api/message', actions\message\POST\MessageAction::class); // tester


// =====================
//     Ressource
// =====================
// GET
$app->get('/api/resources', actions\resource\GET\ResourceAction::class); // ok
$app->get('/api/resource/{id}', actions\resource\GET\ResourceByIdAction::class); // tester


// POST

$app->post('/api/resource', actions\resource\POST\ResourceAction::class); // tester

// PATCH


// =====================
//     Groupe
// =====================
// GET
$app->get('/api/groups', actions\group\GET\GroupAction::class); // ok
$app->get('/api/group/{id}', actions\group\GET\GroupByIdAction::class); // tester

// POST
$app->post('/api/group', actions\group\POST\GroupAction::class); // ok


// PATCH


$app->run();


require_once(__DIR__ . '/../sql/data_generation.php');