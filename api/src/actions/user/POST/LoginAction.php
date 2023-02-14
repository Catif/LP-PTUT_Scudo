<?php

namespace api\actions\user\POST;

use api\services\AuthorizationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;

use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class RegisterAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $body = $rq->getParsedBody();

    try {
      if (!is_array($body)) {
        throw new \Exception("Missing Body");
      }

      if (empty($body['username']) || empty($body['password'])) {
        throw new \Exception("Missing properties");
      }

      $password = UserService::getPassword($body);
      if (!password_verify($body['password'], $password['password'])) {
        throw new \Exception('Password incorrect');
      }
      $user = UserService::getUserByID($password['id_user']);
      $token = AuthorizationService::createAuthorization($user['user'])->token;


      $data = [
        'user' => FormatterObject::formatUser($user['user']),
        'token' => $array['token']
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    } catch (\Exception $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
    }
  }
}
