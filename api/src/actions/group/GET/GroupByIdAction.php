<?php

namespace api\actions\group\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;
use api\models\Group;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Slim\Exception\HttpNotFoundException;

final class GroupByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {

    try {
      $groupById = GroupService::getGroupByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }
    $followings = $groupById->users()->where('User_Group.id_user', $args['id'])->get();
    foreach ($followings as $following) {
      $roleUser = $following['role'];
    }

    $etatFollowing = false;
    $owner = false;
    if ($roleUser == 'owner') {
      $etatFollowing = true;
      $owner = true;
    } elseif ($roleUser == 'member') {
      $etatFollowing = true;
    }

    $data = [
      'Filtre' => 'groupById',
      'count' => count($groupById),
      'result' => [
        'group' => FormatterObject::formatGroup($groupById),
        'following' => $etatFollowing,
        'owner' => $owner
      ]
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
