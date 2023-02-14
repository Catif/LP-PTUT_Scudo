<?php

namespace api\services;


use api\models\Authorization;
use api\models\User;

use Ramsey\Uuid\Uuid;

use Exception;

final class AuthorizationService
{
  static public function createAuthorization(User $user)
  {
    try {
      $authorization = new Authorization();
      $authorization->token = Uuid::uuid4()->toString();
      $authorization->id_user = $user->id_user;
      $authorization->save();

      return $authorization;
    } catch (Exception $e) {
      throw new Exception("Error save token");
    }
  }

  static public function deleteAllAuthorization(User $user)
  {
    try {
      Authorization::where('id_user', $user->id_user)->delete();
    } catch (Exception $e) {
      throw new Exception("Error delete token");
    }
  }
}
