<?php

namespace api\actions\comment\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\CommentService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;
use api\services\utils\FormatterObject;

final class CommentAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $headers = $rq->getHeaders();
        
        $body = $rq->getParsedBody();

        try {
            $token = Authorization::findOrFail($headers['Authorization'][0]);
            $user = $token->user()->first();

            if (!is_array($body)) {
                throw new \Exception("Le body n'existe pas");
            }
            $modelComment = CommentService::insertComment($user,$args['id_resource'],$body);
            $data = [
                'comment' => FormatterObject::formatComment($modelComment)
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
