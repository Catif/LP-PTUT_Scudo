<?php

declare(strict_types=1);

use api\actions as actions;
use api\services\utils\FormatterAPI;

use Slim\Factory\AppFactory as Appfactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory as Appfactory;

use  api\actions as actions;
use api\middleware\TokenMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
try {
  $db = new Illuminate\Database\Capsule\Manager();
  $db->addConnection($conf); /* configuration avec nos paramètres */
  $db->setAsGlobal(); /* rendre la connexion visible dans tout le projet */
  $db->bootEloquent(); /* établir la connexion */
} catch (Exception $e) {
  echo ($e->getMessage());
}


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->options('/{routes:.+}', function ($request, $response, $args) {
  return $response;
});

$app->add(function ($request, $handler) {
  $response = $handler->handle($request);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

// Default route
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world!");

  return $response;
});

// List des routes => https://docs.google.com/document/d/1DWMMHJNmhXVq-R11X4dQVAwZPHYrf-PKavtw7hfs0_Q/edit#
// =====================
//       General
// =====================
$app->post('/api/register', actions\user\POST\RegisterAction::class);
$app->post('/api/login', actions\user\POST\LoginAction::class);
$app->delete('/api/disconnect', actions\user\DELETE\DisconnectAction::class)->add(new TokenMiddleware());

$app->post('/api/upload', actions\general\POST\UploadAction::class)->add(new TokenMiddleware());


// =====================
//        User
// =====================
// GET
$app->get('/api/users', actions\user\GET\UsersAction::class)->add(new TokenMiddleware());
$app->get('/api/user/{id}', actions\user\GET\UserByIdAction::class)->add(new TokenMiddleware());
$app->get('/api/user/{id}/resources', actions\user\GET\UserResourcesAction::class)->add(new TokenMiddleware());

// POST

$app->post('/api/user/{id}/follow', actions\user\POST\FollowAction::class)->add(new TokenMiddleware());

$app->post('/api/user/password_change', actions\user\POST\PasswordChangeAction::class)->add(new TokenMiddleware());

// PATCH
$app->post('/api/user/edit', actions\user\PATCH\UserAction::class)->add(new TokenMiddleware());

// DELETE
$app->delete('/api/user/{id}/unfollow', actions\user\DELETE\UnfollowAction::class)->add(new TokenMiddleware());

// =====================
//     Conversation
// =====================
// GET
$app->get('/api/conversations', actions\conversation\GET\ConversationAction::class)->add(new TokenMiddleware());

// POST



// PATCH



// =====================
//     Message
// =====================
// POST
$app->post('/api/message', actions\message\POST\MessageAction::class)->add(new TokenMiddleware());


// =====================
//     Ressource
// =====================
// GET
$app->get('/api/resources', actions\resource\GET\ResourcesAction::class)->add(new TokenMiddleware());
$app->get('/api/resource/{id}', actions\resource\GET\ResourceByIdAction::class)->add(new TokenMiddleware());


// POST
$app->post('/api/resource', actions\resource\POST\ResourceAction::class)->add(new TokenMiddleware());
$app->post('/api/resource/{id_resource}/group/{id_group}', actions\resource\POST\ResourceGroupShareAction::class)->add(new TokenMiddleware());

// Méthode PATCH impossible en PHP
$app->post('/api/resource/{id}', actions\resource\PATCH\ResourceAction::class)->add(new TokenMiddleware());

// =====================
//     Groupe
// =====================
// GET
$app->get('/api/groups', actions\group\GET\GroupsAction::class)->add(new TokenMiddleware());
$app->get('/api/groups/random', actions\group\GET\GroupsRandomAction::class)->add(new TokenMiddleware());
$app->get('/api/group/{id}', actions\group\GET\GroupByIdAction::class)->add(new TokenMiddleware());
$app->get('/api/group/{id}/resources', actions\group\GET\GroupResourceAction::class)->add(new TokenMiddleware());

// POST
$app->post('/api/group', actions\group\POST\GroupAction::class)->add(new TokenMiddleware());
$app->post('/api/group/{id}/follow', actions\group\POST\GroupFollowAction::class)->add(new TokenMiddleware());

// Méthode PATCH impossible en PHP
$app->post('/api/group/{id}', actions\group\PATCH\GroupAction::class)->add(new TokenMiddleware());

// DELETE
$app->delete('/api/group/{id}/unfollow', actions\group\DELETE\GroupUnfollowAction::class)->add(new TokenMiddleware());


// PATCH

// UPDATE

// =====================
//     Comment
// =====================

// POST
$app->post('/api/comment/{id_resource}', api\actions\comment\POST\CommentAction::class)->add(new TokenMiddleware());

$app->run();


// Génération de fausses données dans la base de donnnées
// require_once(__DIR__ . '/../sql/data_generation.php');