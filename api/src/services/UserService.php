<?php

namespace api\services;


use api\models\User as User;



final class UserService
{
  public function getUser(): array
  {
    return User::select([
      'id_user',
      'fullname',
      'username',
      'email',
      'password',
      'biography',
      'phone',
      'role',
      'created_at',
      'updated_at'
    ])->get()->toArray();
  }

  public function getUserByID($id): ?array
  {
    if (empty($id)) {
      throw new \Exception("Missing id user");
    }

    $user = User::select([
      'id_user',
      'fullname',
      'username',
      'email',
      'biography',
      'phone',
      'role',
      'created_at',
    ])
      ->findOrFail($id);

    $resources = $user->resources()->get();


    return ['user' => $user->toArray(), 'resources' => $resources->toArray()];
  }

  public function insertUser(array $property)
  {
    if (empty($property['fullname']) || empty($property['username']) || empty($property['email']) || empty($property['password']) || empty($property['biography']) || empty($property['phone']) || empty($property['image']) || empty($property['role'])) {
      throw new \Exception("Missing property");
    }
    if (!filter_var($property['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \Exception("Invalid email");
    }

    $user = new User();
    $user->fullname = $property['fullname'];
    $user->username = $property['username'];
    $user->email = $property['email'];
    $user->password = password_hash($property['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    $user->biography = $property['biography'];
    $user->phone = $property['phone'];
    $user->image = $property['image'];
    $user->role = $property['role'];

    try {
      $user->save();
    } catch (\Exception $e) {
      throw new \Exception("Error while saving user");
    }

    try {
      $Authorization = new AuthorizationService();
      $token = $Authorization->createToken($user);
    } catch (\Exception $e) {
      throw new \Exception("Error while linking token to user");
    }

    return ['user' => $user, 'token' => $token];
  }
}
