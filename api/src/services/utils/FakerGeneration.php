<?php

namespace api\services\utils;

use Faker\Factory;
use api\models\User;
use api\models\Resource;

final class FakerGeneration{

    public static function FakeUser():User {
        $faker = Factory::create();

        $newUser = new User;

        $role = ["user","professional"];

        $newUser->role = $role[rand(0,1)];
        $newUser->email = $faker->email();
        $newUser->password = password_hash("1234", PASSWORD_BCRYPT,['cost' => 12]);
        $newUser->biography = $faker->paragraph(2);
        $newUser->image = $faker->imageUrl(500, 500);

        if($newUser->role === "user"){
            $newUser->username = $faker->userName();
        } elseif($newUser->role === "professional"){
            $newUser->fullname = "{$faker->firstName()} {$faker->lastName()}";
            $newUser->phone = "0650366517";
        }
    
        $newUser->save();

        return $newUser;
    }

    public static function FakerResource():void {
        $faker = Factory::create();
        
        $newResource = new Resource;

        $type = ["stream","video","text"];
        
        $newResource->type = $type[rand(0,1)];
        $newResource->title = $faker->sentence(3);
        $newResource->text = $faker->words(25, true);
        $newResource->longitude = $faker->longitude();
        $newResource->latitude = $faker->latitude();
        $newResource->is_private = 1;
        
        if($newResource->type === "stream"){
            $newResource->filename = "test";
        } elseif($newResource->type === "video"){
            $newResource->filename = "test";
        }

        $newResource->save();
    }
}