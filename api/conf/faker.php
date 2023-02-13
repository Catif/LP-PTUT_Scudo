<?php 
require __DIR__ . '/../vendor/autoload.php';

use api\services\UserService;


$faker = Faker\Factory::create();

$newUser = new UserService;
$data = [
    'username' => $faker->userName(),
    'email' => $faker->email(),
];


