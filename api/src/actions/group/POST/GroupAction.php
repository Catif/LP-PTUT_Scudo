<?php

namespace api\actions\group\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;
use api\services\utils\FormatterObject;

final class GroupAction
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
            $modelGroup = GroupService::insertGroup($user, $body);

            $data = [
                'result' => [
                    'group' => FormatterObject::formatGroup($modelGroup)
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
