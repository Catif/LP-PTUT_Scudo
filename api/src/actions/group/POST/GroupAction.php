<?php

namespace api\actions\group\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



use api\services\GroupService;
use api\services\utils\FormatterAPI;

final class GroupAction
{


    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $groupService = new GroupService;
        $body = $rq->getParsedBody();
        $groupInsert = $groupService->insertGroup($body);

        $rs->getBody()->write(json_encode($groupInsert));

        return $rs;
    }
}
