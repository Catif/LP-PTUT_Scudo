<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory as Appfactory;

use  api\actions as actions; 

require __DIR__ . '/../vendor/autoload.php';

$conf = parse_ini_file(__DIR__ . '/../conf/db.conf.ini');
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection($conf); /* configuration avec nos paramètres */
$db->setAsGlobal(); /* rendre la connexion visible dans tout le projet */
$db->bootEloquent(); /* établir la connexion */


$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->get('/', function (Request $request, Response $response, $args) {
  $response->getBody()->write("Hello world!");
  
  return $response;
});

// Api

$app->get('/api/users', actions\user\UserAction::class); // OK
$app->get('/api/comments', actions\comment\CommentAction::class); // OK
$app->get('/api/conversations', actions\conversation\ConversationAction::class); // Ok
$app->get('/api/messages', actions\message\MessageAction::class); // ok
$app->get('/api/resources', actions\resource\ResourceAction::class); // ok
$app->get('/api/groups', actions\group\GroupAction::class); // ok

// SELECT BY ID

$app->get('/users/{id}', api\actions\user\UserByIdAction::class);  // ok
$app->post('/api/post/test', api\actions\user\UserPostAction::class );




$app->run();
