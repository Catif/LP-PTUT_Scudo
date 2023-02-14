<?php

namespace api\actions\group\PATCH;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;

final class GroupAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $groupService = new GroupService;

        $body = $rq->getParsedBody();

        try {
            if (!is_array($rq)) {
                throw new \Exception("Missing Body");
            }
            $modelGroup = $groupService->updateGroup($args['id'],$body);
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
        $rq->getBody()->write(json_encode($modelGroup));
        return  $rq;// 201 = Created
    }
}
