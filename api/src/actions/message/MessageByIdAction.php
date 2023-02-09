<?php

namespace api\actions\resourc;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\MessageService as MessageService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Slim\Exception\HttpNotFoundException;

final class MessageByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response {
    $messageService = new MessageService();
    try {
      $messageById = $messageService->getMessageByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }
    $data = [
      'Filtre' => 'messageById',
      'Result' => $messageById
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}