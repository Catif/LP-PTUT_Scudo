<?php

namespace api\actions\user\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\UserService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use api\services\utils\FormatterObject;
use Exception;
use Slim\Exception\HttpNotFoundException;

final class UserByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    try {
      $array = UserService::getUserByID($args['id']);
    } catch (Exception  $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 404);
    }

    $ressources = [];
    foreach ($array['resources'] as $resource) {
      $ressources[] = FormatterObject::formatResource($resource);
    }

    $user = FormatterObject::formatUser($array['user']);

    $data = [
      'request' => '/api/user/' . $args['id'],
      'result' => [
        'user' => $user,
        'resources' => $ressources
      ]
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
