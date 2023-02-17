<?php

namespace api\actions\user\PATCH;

use api\models\Authorization;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class UserAction
{
  public function __invoke(Request $rq, Response $rs): Response
  {
    $body = $rq->getParsedBody();
    $header = $rq->getHeaders();
    try {
      $this->validateBody($body);
      $token = Authorization::findOrFail($header['Authorization'][0]);
      $user = $token->user()->first();

      $newUser = UserService::editUser($user, $body);

      $data = [
        'result' => [
          'user' => FormatterObject::formatUser($newUser)
        ]
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data);
    } catch (\Exception $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 400);
    }
  }

  private function validateBody($body)
  {
    if (!isset($body['image']) && !isset($body['biography']) && !isset($body['password']) && !isset($body['username'])) {
      throw new \Exception("Au moins un des champs requis n'a pas été renseigné.");
    }
  }
}
