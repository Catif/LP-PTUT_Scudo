<?php

namespace api\actions\conversation\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ConversationService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;
use api\services\utils\FormatterObject;

final class ConversationAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $headers = $rq->getHeaders();
        $token = Authorization::find($headers['API-Token'][0]);
        $user = $token->user()->first();
        
        $body = $rq->getParsedBody();


        try {
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }
            $modelGroup = ConversationService::insertConversation($user,$body);

            $data = [
                'group' => FormatterObject::formatGroup($modelGroup)
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created

        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }


    }
}
