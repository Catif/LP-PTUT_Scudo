<?php

namespace api\actions;


use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ConversationService as ConversationService;
use api\services\utils\FormatterAPI;

final class ConversationAction {

    
    public function __invoke(Request $rq, Response $rs, array $args) : Response
    {
        $conversationService = new ConversationService; 
        $conversation = $conversationService->getConversation();
        $data = ['type' => 'Table',
        'count'=> count($conversation),
        'Conversation'=> $conversation];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
} 