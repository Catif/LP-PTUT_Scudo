<?php

namespace api\actions\user\POST;

use api\models\Authorization;
use api\services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use api\services\utils\FormatterAPI;

final class FollowAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $header = $rq->getHeaders();
    try {
      $token = Authorization::findOrFail($header['Authorization'][0]);
      $userToken = $token->user()->first();
      $userSearch = UserService::getUserByID($args['id']);

      UserService::follow($userToken, $userSearch);

      $data = [

        'result' => [
          'result' => "Vous suivez désormais {$userSearch->username}"
        ]
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
