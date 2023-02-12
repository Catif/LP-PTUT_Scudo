<?php

namespace api\actions\user\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;
use api\services\utils\FormatterAPI;

final class RegisterAction
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
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }

        $data = [
            'user' => $modelUser
        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }
}
