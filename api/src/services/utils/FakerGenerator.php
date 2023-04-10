<?php

namespace api\services\utils;

use Faker\Factory;
use api\models\User;
use api\models\Group;
use Ramsey\Uuid\Uuid;
use api\models\Comment;
use api\models\Resource;

final class FakerGenerator
{
    private $faker;

    public function __construct($fakerFactory)
    {
        $this->faker = $fakerFactory;
    }

    public function FakeUser(): User
    {
        $newUser = new User;

        $role = ["user", "professional"];

        $newUser->role = $role[rand(0, 1)];
        $newUser->id_user = Uuid::uuid4()->toString();
        $newUser->username = $this->faker->userName();
        $newUser->email = $this->faker->email();
        $newUser->password = password_hash("1234", PASSWORD_BCRYPT, ['cost' => 12]);
        $newUser->biography = $this->faker->paragraph(2);
        $newUser->image = $this->faker->imageUrl(500, 500);

        if ($newUser->role === "professional") {
            $newUser->fullname = "{$this->faker->firstName()} {$this->faker->lastName()}";
            $newUser->phone = "0650366517";
        }

        $newUser->save();

        echo "Fake user generated !<br/>";

        return $newUser;
    }

    public function FakeGroup(User $user): Group
    {
        $newGroup = new Group;

        $newGroup->id_group = Uuid::uuid4()->toString();
        $newGroup->name = $this->faker->word();
        $newGroup->description = $this->faker->words(15, true);
        $newGroup->image = $this->faker->imageUrl(500, 250);

        $newGroup->save();

        $newGroup->users()->attach($user, ['role' => 'owner']);

        echo "Fake group generated !<br/>";

        return $newGroup;
    }

    public function FakeResource(User $user): ?Resource
    {
        $newResource = new Resource;

        $type = ["stream", "video", "text"];

        $newResource->id_resource = Uuid::uuid4()->toString();
        $newResource->type = $type[rand(0, 2)];
        $newResource->title = $this->faker->sentence(3);
        $newResource->text = $this->faker->words(25, true);
        $newResource->longitude = $this->faker->longitude();
        $newResource->latitude = $this->faker->latitude();
        $newResource->is_private = 1;

        if ($newResource->type === "stream") {
            $newResource->filename = "test";
        } elseif ($newResource->type === "video") {
            $newResource->filename = "test";
        }

        if ($user->role === "user") {
            $user->resources()->save($newResource);
            echo "Fake resource generated !<br/>";
            return $newResource;
        } else {
            echo ("Data unregistered due to User role : Professional<br/>");
            return null;
        }
    }

    public function FakeGroupResource(User $user, Group $group): ?Resource
    {
        $newGroupResource = new Resource;

        $type = ["stream", "video", "text"];

        $newGroupResource->id_resource = Uuid::uuid4()->toString();
        $newGroupResource->type = $type[rand(0, 2)];
        $newGroupResource->title = $this->faker->sentence(3);
        $newGroupResource->text = $this->faker->words(25, true);
        $newGroupResource->longitude = $this->faker->longitude();
        $newGroupResource->latitude = $this->faker->latitude();
        $newGroupResource->is_private = 1;

        if ($newGroupResource->type === "stream") {
            $newGroupResource->filename = "test";
        } elseif ($newGroupResource->type === "video") {
            $newGroupResource->filename = "test";
        }

        if ($user->role === "user") {
            $user->resources()->save($newGroupResource);
            $newGroupResource->groups()->attach($group);
            echo "Fake group resource generated !<br/>";
            return $newGroupResource;
        } else {
            echo ("[GROUP RESOURCE] Data unregistered due to User role : Professional<br/>");
            return null;
        }
    }

    public function FakeComment(User $user, Resource $resource)
    {
        $newComment = new Comment;

        $newComment->id_comment = Uuid::uuid4()->toString();
        $newComment->content = $this->faker->text(225);

        $newComment->id_user = $user->id_user;
        $newComment->id_resource = $resource->id_resource;

        $newComment->save();

        echo "Fake comment generated !<br/>";

        // $user->comments()->save($newComment);
        // $resource->comments()->save($newComment);
    }

    public function FakeFollow(User $user, int $max): void
    {
        $uuids = [];
        $uuids = User::select(['id_user'])->get();

        $userFollowed = $uuids[rand(0, $max)];

        if ($user->id_user === $userFollowed) {
            echo "A user cannot follow himself !<br/>";
        }

        echo "Fake follow generated !<br/>";

        $user->follows()->attach($userFollowed);
    }
}
