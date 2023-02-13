<?php

namespace api\services;


use api\models\Authorization;
use api\models\User;

use Exception;

final class AuthorizationService
{
  public function createToken(User $user)
  {
    try {
      $token = new Authorization();
      $token->user()->attache($user);
      $token->save();
    } catch (Exception $e) {
      throw new Exception("Error save token");
    }
  }
}
