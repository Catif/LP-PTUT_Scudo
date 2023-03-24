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
use api\services\utils\FormatterObject;
use Exception;
use Slim\Exception\HttpNotFoundException;

final class ResourceByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $header = $rq->getHeaders();

    try {
      $array = ResourceService::getResourceByID($args['id']);
      if ($array['resource']->is_private == 1) {
        $token = Authorization::findOrFail($header['Authorization'][0]);
        $user = $token->user()->first();
        if ($array['resource']->id_user != $user->id_user) {
          throw new Exception("Vous n'avez pas la permission pour cette ressource.");
        }
      }
    } catch (Exception  $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 401);
    }
    $allComment = [];
    foreach ($array['comment'] as $comment) {
      $allComment[] = FormatterObject::formatComment($comment);
    }


    $data = [
      'result' => [
        'resource' => FormatterObject::formatResource($array['resource']),
        'comments' => $allComment
      ]

    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
