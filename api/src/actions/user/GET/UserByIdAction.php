<?php

namespace api\actions\user\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\UserService as UserService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Slim\Exception\HttpNotFoundException;

final class UserByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $userService = new UserService();
    try {
      $array = $userService->getUserByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }

    $ressources = [];
    foreach ($array['resources'] as $resource) {
      $ressources[] = [
        'id' => $resource['id_resource'],
        'type' => $resource['type'],
        'url' => [
          'api' => '/api/resource/' . $resource['id_resource'],
          'file' => $resource['filename']
        ],
        'title' => $resource['title'],
        'description' => $resource['text'],
        'localisation' => [
          'latitude' => $resource['latitude'],
          'longitude' => $resource['longitude'],
        ],
        'created_at' => $resource['created_at'],
        'updated_at' => $resource['updated_at'],
        'published_at' => $resource['published_at'],
      ];
    }

    $user = [
      'id' => $array['user']['id_user'],
      'fullname' => $array['user']['fullname'],
      'username' => $array['user']['username'],
      'email' => $array['user']['email'],
      'biography' => $array['user']['biography'],
      'phone' => $array['user']['phone'],
      'role' => $array['user']['role'],
      'created_at' => $array['user']['created_at'],
    ];

    $data = [
      'Filtre' => 'UserById',
      'Result' => [
        'User' => $user,
        'Resources' => $ressources
      ]
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
