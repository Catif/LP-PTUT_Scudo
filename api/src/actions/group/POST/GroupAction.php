<?php

namespace api\actions\group\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;

use api\models\Authorization;
use Slim\Psr7\Header;
use Slim\Psr7\Headers;

final class GroupAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $headers = $rq->getHeaders();
        $token = Authorization::find($headers['API-Token'][0]); // 
        $useToken = $token->user;

        $groupService = new GroupService;
        $body = $rq->getParsedBody();
        $user = 'id_user'; // récupérer l'id de l'utilisateur


        try {
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }
            $modelGroup = $groupService->insertGroup($useToken,$body);
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }

        $data = [
            'group' => $modelGroup
        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }
}
