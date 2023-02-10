<?php

namespace api\actions\user;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;
use api\services\utils\FormatterAPI;

final class UserPostAction
{


    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $userService = new UserService;
        $body = $rq->getParsedBody();
        $modelUser = $userService->insertUser($body);

        $rs->getBody()->write(json_encode($modelUser));

        return $rs;
    }
}
