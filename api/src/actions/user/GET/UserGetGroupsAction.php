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
use api\services\GroupService;
use api\services\utils\FormatterObject;
use Exception;
use Slim\Exception\HttpNotFoundException;

final class UserGetGroupsAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    try {
      $groups = GroupService::getGroupsOfUser($args['id']);

      $groupsFormated = [];
      foreach ($groups as $group) {
        $groupsFormated[] = FormatterObject::formatGroup($group);
      }

      $data = [
        'result' => [
          'groups' => $groupsFormated
        ]
      ];
    } catch (Exception  $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 404);
    }



    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
