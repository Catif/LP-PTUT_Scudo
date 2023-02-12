<?php

namespace api\actions\resource\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\ResourceService as ResourceService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Slim\Exception\HttpNotFoundException;

final class ResourceByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $resourceService = new ResourceService();
    try {
      $resourceById = $resourceService->getResourceByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }
    $data = [
      'Filtre' => 'resourceById',
      'Result' => $resourceById
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
