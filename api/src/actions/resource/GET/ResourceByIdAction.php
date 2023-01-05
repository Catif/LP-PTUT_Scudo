<?php

namespace api\actions\resource\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\ResourceService as ResourceService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use api\models\Authorization;
use Exception;
use Slim\Exception\HttpNotFoundException;

final class ResourceByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $header = $rq->getHeaders();

    try {
      $resource = ResourceService::getResourceByID($args['id']);
      if ($resource->is_private == 1) {
        $token = Authorization::findOrFail($header['API-Token'][0]);
        $user = $token->user()->first();
        if ($resource->id_user != $user->id_user) {
          throw new Exception("You don't have permission to acces this resource");
        }
      }
    } catch (Exception  $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 401);
    }
    $data = [
      'Result' => $resource
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
