<?php 
require __DIR__ . '/../vendor/autoload.php';

use api\services\UserService;


// Initialisation de Faker
$faker = Faker\Factory::create();


// User
$role = ["user","professional"];

$newUser = new UserService;

$data = [
    'fullname' => "$faker->firstName $faker->lastName",
    'username' => $faker->userName(),
    'email' => $faker->email(),
    'password' => password_hash("12345", PASSWORD_DEFAULT),
    'biography' => $faker->paragraph(),
    'phone' => $faker->randomNumber(10, true),
    'image' => $faker->imageUrl(500, 500),
    'role' => $role[rand(0,1)]
];





