<?php

namespace api\actions\message\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\MessageService;
use api\services\utils\FormatterAPI;

final class MessageAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $messageService = new MessageService;
        $body = $rq->getParsedBody();
        try {
            $modelMessage = $messageService->insertMessage($body);
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }

        $data = [
            'user' => $modelMessage
        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }
}
