<?php

namespace api\actions\group\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;
use api\services\utils\FormatterObject;

final class GroupFollowAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $headers = $rq->getHeaders();

        try {
            $token = Authorization::findOrFail($headers['Authorization'][0]);
            $user = $token->user()->first();

            $group = GroupService::getGroupById($args['id']);

            GroupService::insertGroupFollow($user, $group);

            $data = [
                'result' => [
                    'message' => "Vous venez se follow le groupe."
                ]
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
