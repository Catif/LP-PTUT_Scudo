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
        $token = Authorization::find($headers['API-Token'][0]);
        $user = $token->user()->first();
        
        $groupService = new CommentService;
        $body = $rq->getParsedBody();


        try {
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }
            $modelComment = $groupService->insertComment($user,$args['id_resource'],$body);
            $comments[] = [];
            foreach($modelComment as $comments){
                $comment = $comments;
            }
            $data = [
                'count' => count($comment),
                'group' => FormatterObject::formatComment($comment)
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
