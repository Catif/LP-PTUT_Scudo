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
  
      $user = User::select([
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
      ])->findOrFail($id);


    return $user->toArray();
  }

  public function insertUser(array $property)
  {
    $modelsUser = new User();
    $modelsUser->fullname = $property['fullname'];
    $modelsUser->username = $property['username'];
    $modelsUser->email = $property['email'];
    $modelsUser->password = $property['password'];
    $modelsUser->biography = $property['biography'];
    $modelsUser->phone = $property['phone'];
    $modelsUser->image = $property['image'];
    $modelsUser->role = $property['role'];

    $modelsUser->save();

    return $modelsUser;
  }



}