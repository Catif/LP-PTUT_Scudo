<?php

namespace api\services\utils;

use Faker\Factory;
use api\models\User;
use api\models\Resource;

final class FakerGeneration{

    public static function FakeUser():void {
        $faker = Factory::create();

        $newUser = new User;

        $newUser->username = $faker->userName();
        $newUser->email = $faker->email();
        $newUser->password = password_hash("1234", PASSWORD_BCRYPT,['cost' => 12]);
        $newUser->biography = $faker->paragraph(2);
        $newUser->image = $faker->imageUrl(500, 500);
        $newUser->role = "user";
    
        $newUser->save();
    }

    public static function FakeProfessional():void {
        $faker = Factory::create();
        $faker_FR = Factory::create('fr_FR');

        $newProfessional = new User;

        $newProfessional->fullname = "{$faker->firstName()} {$faker->lastName()}";
        $newProfessional->email = $faker->email();
        $newProfessional->password = password_hash("1234", PASSWORD_BCRYPT,['cost' => 12]);
        $newProfessional->biography = $faker->paragraph(2);
        $newProfessional->phone = $faker_FR->mobileNumber();
        $newProfessional->image = $faker->imageUrl(500, 500);
        $newProfessional->role = "professional";

        $newProfessional->save();
    }

    public static function FakerResource(User $user):void {
        $faker = Factory::create();
        
        $newResource = new Resource;

        $type = ["stream", "video", "text"];
        
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