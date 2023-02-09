<?php

namespace api\actions\message;


use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\MessageService as MessageService;
use api\services\utils\FormatterAPI;

final class MessageAction {

    
    public function __invoke(Request $rq, Response $rs, array $args) : Response
    {
        $messageService = new MessageService; 
        $messages = $messageService->getMessage();
        $data = ['type' => 'Table',
        'count'=> count($messages),
        'Message'=> $messages];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
} 