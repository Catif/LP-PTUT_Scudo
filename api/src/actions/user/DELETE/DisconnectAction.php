<?php

namespace api\actions\user\DELETE;

use api\models\Authorization;
use api\services\AuthorizationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use api\services\utils\FormatterAPI;

final class DisconnectAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $header = $rq->getHeaders();
    try {
      $token = Authorization::findOrFail($header['API-Token'][0]);
      $user = $token->user()->first();

      AuthorizationService::deleteAllAuthorization($user);

      $data = [

        'result' => [
          'result' => "L'utilisateur a bien été déconnecté."
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
