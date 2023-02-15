<?php

namespace api\services;


use api\models\User as User;
use Exception;

final class UserService
{
  static public function exist($property): bool
  {
    if (!empty($property['email']) && !empty($property['username'])) {
      return User::where('email', $property['email'])->orWhere('username', $property['username'])->exists();
    }
    if (!empty($property['email'])) {
      return User::where('email', $property['email'])->exists();
    }
    if (!empty($property['username'])) {
      return User::where('username', $property['username'])->exists();
    }
    throw new \Exception("Missing email and username");
  }

  static public function getUsers($q)
  {
    return User::select([
      'id_user',
      'fullname',
      'username',
      'email',
      'biography',
      'phone',
      'role',
      'created_at',
      'updated_at'
    ])->where('username', 'LIKE', "%{$q}%")->orWhere("fullname", "LIKE", "%{$q}%")->get();
  }

  static public function getUserByID($id): ?array
  {
    $user = User::select([
      'id_user',
      'fullname',
      'username',
      'email',
      'biography',
      'phone',
      'role',
      'created_at',
      'updated_at'
    ])->findOrFail($id);

    $resources = $user->resources()->get();


    return ['user' => $user, 'resources' => $resources->toArray()];
  }

  static public function getPassword($type, $username)
  {
    try {
      return User::select(['id_user', 'password'])->where($type, $username)->firstOrFail();
    } catch (Exception $e) {
      throw new \Exception("User does not exist");
    }
  }

  static public function register(array $property)
  {
    $user = new User();
    $user->fullname = $property['fullname'];
    $user->username = $property['username'];
    $user->email = $property['email'];
    $user->password = $property['password'];
    $user->biography = $property['biography'];
    $user->phone = $property['phone'];
    $user->image = $property['image'];
    $user->role = $property['role'];

    try {
      $user->save();
    } catch (\Exception $e) {
      throw new \Exception("Error while saving user");
    }

    return $user;
  }
}
