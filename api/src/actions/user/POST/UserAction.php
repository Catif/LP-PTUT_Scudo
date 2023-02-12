<?php

namespace api\actions\user\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;
use api\services\utils\FormatterAPI;

final class UserAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $userService = new UserService;
        $body = $rq->getParsedBody();
        try {
            $modelUser = $userService->insertUser($body);
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400);
            return $rs;
        }


        $rs->getBody()->write(json_encode($modelUser));

        return $rs;
    }
}
