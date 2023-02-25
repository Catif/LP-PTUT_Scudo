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
use api\models\Authorization;
use Slim\Exception\HttpNotFoundException;

final class GroupByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $headers = $rq->getHeaders();


    try {
      $token = Authorization::findOrFail($headers['Authorization'][0]);
      $user = $token->user()->first();

      $groupById = GroupService::getGroupByID($args['id']);
      $following = $groupById->users()->find($user->id_user);
      $followers = $groupById->users()->count();

      $etatFollowing = false;
      $owner = false;
      if (isset($following)) {
        if ($following->pivot->role == 'owner') {
          $etatFollowing = true;
          $owner = true;
        } elseif ($following->pivot->role == 'member') {
          $etatFollowing = true;
        }
      }

      $data = [
        'result' => [
          'group' => FormatterObject::formatGroup($groupById),
          'followers' => $followers,
          'following' => $etatFollowing,
          'owner' => $owner
        ]
      ];

      return FormatterAPI::formatResponse($rq, $rs, $data);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }
  }
}
