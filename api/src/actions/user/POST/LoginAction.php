<?php

namespace api\actions\user\POST;

use api\services\AuthorizationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;

use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class LoginAction
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

      if (filter_var($body['username'], FILTER_VALIDATE_EMAIL)) {
        $userFind = UserService::getPassword('email', $body['username']);
      } else {
        $userFind = UserService::getPassword('username', $body['username']);
      }

      if (!password_verify($body['password'], $userFind['password'])) {
        throw new \Exception('Password incorrect');
      }

      $user = UserService::getUserByID($userFind['id_user']);

      AuthorizationService::deleteAllAuthorization($user['user']);
      $token = AuthorizationService::createAuthorization($user['user'])->token;


      $data = [
        'user' => FormatterObject::formatUser($user['user']),
        'token' => $token
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
