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
      $user->authorization()->save($authorization);


      return $authorization;
    } catch (Exception $e) {
      throw new Exception("Le token n'a pas pu être créé.");
    }
  }

  static public function deleteAllAuthorization(User $user)
  {
    try {
      Authorization::where('id_user', $user->id_user)->delete();
    } catch (Exception $e) {
      throw new Exception("Le token n'a pas pu être supprimé.");
    }
  }

  static public function deleteAllAuthorization(User $user)
  {
    try {
      Authorization::where('id_user', $user->id_user)->delete();
    } catch (Exception $e) {
      throw new Exception("Le token n'a pas pu être supprimé.");
    }
  }
}
