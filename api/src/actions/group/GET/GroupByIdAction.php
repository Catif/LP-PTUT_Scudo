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
use Slim\Exception\HttpNotFoundException;

final class GroupByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $groupService = new GroupService();
    try {
      $groupById = $groupService->getGroupByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }

    $data = [
      'Filtre' => 'groupById',
      'Result' => [
        'group' => FormatterObject::formatGroup($groupById)
      ]
      ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
