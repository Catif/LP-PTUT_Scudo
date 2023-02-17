<?php

namespace api\actions\group\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Exception;
use Slim\Exception\HttpNotFoundException;

final class GroupResourceAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $query = $rq->getQueryParams();
    try {
      $page = isset($query['page']) ? $query['page'] : 1;
      $groupResource = GroupService::getResource($args['id'], $page, $query['limit']);
    } catch (Exception  $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 404);
    }

    $listResources = [];
    foreach ($groupResource as $resource) {
      $listResources[] = FormatterObject::formatResource($resource);
    }
    $data = [
      'Filtre' => 'groupResource',
      'count' => count($listResources),
      'result' => [
        'groupResource' =>  $listResources
      ]
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
