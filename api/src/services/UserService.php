<?php

namespace api\services;


use api\models\User as User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
    try {
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
    } catch (ModelNotFoundException $e) {
        new Exception("error getUserById");
    }

    return $user->toArray();
  }
}