<?php

namespace api\services\utils;

use Faker\Factory;
use api\models\User;
use api\models\Group;
use Ramsey\Uuid\Uuid;
use api\models\Resource;

final class FakerGenerator{
    private $faker;

    public function __construct($fakerFactory){
        $this->faker = $fakerFactory;
    }

    public function FakeUser():User {
        $newUser = new User;

        $role = ["user","professional"];

        $newUser->role = $role[rand(0,1)];
        $newUser->id_user = Uuid::uuid4()->toString();
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

    public function FakeGroup(User $user){
        $newGroup = new Group;

        $newGroup->id_group = Uuid::uuid4()->toString();
        $newGroup->name = $this->faker->sentence(1);
        $newGroup->description = $this->faker->words(15, true);
        $newGroup->image = $this->faker->imageUrl(500, 250);

        $newGroup->save();

        $newGroup->users()->attach($user, ['role' => 'owner']);
    }

    public function FakeResource(User $user, Group $group):void {
        $newResource = new Resource;

        $type = ["stream","video","text"];
        
        $newResource->id_resource = Uuid::uuid4()->toString();
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
        if($user->role === "user"){
            $user->resources()->save($newResource);
        }

        
    }

}