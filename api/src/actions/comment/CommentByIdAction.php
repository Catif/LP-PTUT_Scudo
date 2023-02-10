<?php

namespace api\actions\comment;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\CommentService as CommentService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Slim\Exception\HttpNotFoundException;

final class CommentByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response {
    $commentService = new CommentService();
    try {
      $commentById = $commentService->getCommentByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }
    $data = [
      'Filtre' => 'commentById',
      'Result' => $commentById
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}