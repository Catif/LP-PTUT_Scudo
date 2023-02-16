<?php
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\CommentService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;
use api\services\utils\FormatterObject;
use Illuminate\Support\Facades\Response;

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
            $modelGroup = $groupService->insertComment($user,$args['resource'],$body);
            $groups[] = [];
            foreach($modelGroup as $group){
                $groups = $group;
            }
            $data = [
                'count' => count($groups),
                'group' => FormatterObject::formatGroup($groups)
            ];
            return $rs;// 201 = Created

        } catch (\Exception $e) {
           
        }


    }
}