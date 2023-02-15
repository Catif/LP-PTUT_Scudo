<?php

namespace api\services\utils;

use Faker\Factory;
use Ramsey\Uuid\Uuid;
use api\models\User;
use api\models\Resource;

final class FakerGeneration{
    private $faker;

    public function __construct($fakerFactory){
        $this->faker = $fakerFactory;
    }

    public function FakeUser():User {

        $newUser = new User;

        $role = ["user","professional"];

        $newUser->id_user = Uuid::uuid4()->toString();
        $newUser->role = $role[rand(0,1)];
        $newUser->username = $this->faker->userName();
        $newUser->email = $this->faker->email();
        $newUser->password = password_hash("1234", PASSWORD_BCRYPT,['cost' => 12]);
        $newUser->biography = $this->faker->paragraph(2);
        $newUser->image = $this->faker->imageUrl(500, 500);

        if($newUser->role === "professional"){
            $newUser->fullname = "{$this->faker->firstName()} {$this->faker->lastName()}";
            $newUser->phone = "0650366517";
        }
    
        $newUser->save();

        return $newUser;
    }

    public function FakerResource(User $user):void {
        $faker = Factory::create();
        
        $newResource = new Resource;

        $type = ["stream","video","text"];
        
        $newResource->type = $type[rand(0,1)];
        $newResource->title = $this->faker->sentence(3);
        $newResource->text = $this->faker->words(25, true);
        $newResource->longitude = $this->faker->longitude();
        $newResource->latitude = $this->faker->latitude();
        $newResource->is_private = 1;
        
        if($newResource->type === "stream"){
            $newResource->filename = "test";
        } elseif($newResource->type === "video"){
            $newResource->filename = "test";
        }

        

        $user->resources()->save($newResource);
    }
}