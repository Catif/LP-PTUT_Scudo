<?php

namespace api\actions\group\DELETE;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;


final class GroupUnfollowAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $headers = $rq->getHeaders();


        $body = $rq->getParsedBody();



        try {
            $token = Authorization::find($headers['Authorization'][0]);
            $user = $token->user()->first();

            $group = GroupService::getGroupById($args['id']);

            GroupService::deleteGroupFollow($user, $group);

            $data = [
                'result' => [
                    'message' => "Vous avez arrêté de suivre ce groupe."
                ]
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 202); // 201 = Accepted
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }
    }
}
