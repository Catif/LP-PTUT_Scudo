<?php

declare(strict_types=1);

use api\actions as actions;
use api\services\UserService;
use api\services\ResourceService;
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




// Fake data generation

$faker = Faker\Factory::create();
$fakerFR = Faker\Factory::create('fr_FR');

// User
$role = ["user","professional"];

$newUser = new UserService;

$data = [
    'fullname' => "$faker->firstName $faker->lastName",
    'username' => $faker->userName(),
    'email' => $faker->email(),
    'password' => password_hash("1234", PASSWORD_DEFAULT),
    'biography' => $faker->paragraph(),
    'phone' => $fakerFR->mobileNumber(),
    'image' => $faker->imageUrl(500, 500),
    'role' => $role[rand(0,1)]
];

$newUser->insertUser($data);

// Resource
$newResource = new ResourceService;



