<?php

namespace api\actions\group\POST;


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
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }
            $modelGroup = $groupService->insertGroup($body);
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
