<?php

namespace api\actions\conversation\GET;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// SERVICE
use api\services\ConversationService as ConversationService;
use api\services\utils\FormatterAPI;

//Exception
use api\errors\exceptions\RessourceNotFoundException as RessourceNotFoundException;
use Slim\Exception\HttpNotFoundException;

final class ConversationByIdAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $conversationService = new ConversationService();
    try {
      $conversationById = $conversationService->getConversationByID($args['id']);
    } catch (RessourceNotFoundException  $e) {
      throw new HttpNotFoundException($rq, $e->getMessage());
    }
    $data = [
      'Filtre' => 'conversationById',
      'Result' => $conversationById
    ];

    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
