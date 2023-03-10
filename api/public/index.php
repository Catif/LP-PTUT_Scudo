<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory as Appfactory;

use  api\actions as actions;

require __DIR__ . '/../vendor/autoload.php';

$conf = parse_ini_file(__DIR__ . '/../conf/db.ini');
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection($conf); /* configuration avec nos paramètres */
$db->setAsGlobal(); /* rendre la connexion visible dans tout le projet */
$db->bootEloquent(); /* établir la connexion */


$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();



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
$app->get('/api/users', actions\user\GET\UsersAction::class);
$app->get('/api/user/{id}', actions\user\GET\UserByIdAction::class);
$app->get('/api/user/{id}/resources', actions\user\GET\UserResourcesAction::class);

// POST
$app->post('/api/register', actions\user\POST\RegisterAction::class);
$app->post('/api/login', actions\user\POST\LoginAction::class);
$app->post('/api/user/{id}/follow', actions\user\POST\FollowAction::class);


// PATCH
$app->post('/api/user/edit', actions\user\PATCH\UserAction::class);

// DELETE
$app->delete('/api/disconnect', actions\user\DELETE\DisconnectAction::class);
$app->delete('/api/user/{id}/unfollow', actions\user\DELETE\UnfollowAction::class);

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
$app->get('/api/resources', actions\resource\GET\ResourcesAction::class); // ok
$app->get('/api/resource/{id}', actions\resource\GET\ResourceByIdAction::class); // tester


// POST
$app->post('/api/resource', actions\resource\POST\ResourceAction::class); // tester
$app->post('/api/resource/{id_resource}/group/{id_group}', actions\resource\POST\ResourceGroupShareAction::class);

// Méthode PATCH impossible en PHP
$app->post('/api/resource/{id}', actions\resource\PATCH\ResourceAction::class);

// =====================
//     Groupe
// =====================
// GET
$app->get('/api/groups', actions\group\GET\GroupsAction::class); // ok
$app->get('/api/group/{id}', actions\group\GET\GroupByIdAction::class); // ok
$app->get('/api/group/{id}/resources', actions\group\GET\GroupResourceAction::class);

// POST
$app->post('/api/group', actions\group\POST\GroupAction::class); // ok
$app->post('/api/group/{id}/follow', actions\group\POST\GroupFollowAction::class); // ok

// Méthode PATCH impossible en PHP
$app->post('/api/group/{id}', actions\group\PATCH\GroupAction::class); // ok

// DELETE
$app->delete('/api/group/{id}/unfollow', actions\group\DELETE\GroupUnfollowAction::class); // ok


// PATCH

// UPDATE

// =====================
//     Comment
// =====================

// POST
$app->post('/api/comment/{id_resource}', api\actions\comment\POST\CommentAction::class);

$app->run();
