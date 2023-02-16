<?php

namespace api\actions\user\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\UserService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use api\models\Authorization;
use api\services\utils\FormatterObject;
use Exception;
use Slim\Exception\HttpNotFoundException;

final class UserByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $header = $rq->getHeaders();
    try {
      $token = Authorization::findOrFail($header['API-Token'][0]);
      $userToken = $token->user()->first();
      $userSearch = UserService::getUserByID($args['id']);
    } catch (Exception  $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 404);
    }


    $user = FormatterObject::formatUser($userSearch);

    $data = [
      'request' => '/api/user/' . $args['id'],
      'result' => [
        'user' => $user,
      ]
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
