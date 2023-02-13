<?php

namespace api\actions\user\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;

use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class RegisterAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $userService = new UserService;
        $body = $rq->getParsedBody();

        try {
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }
            $array = $userService->insertUser($body);
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }

        $data = [
            'user' => FormatterObject::formatUser($array['user']),
            'token' => $array['token']
        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }
}
