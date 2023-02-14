<?php

namespace api\actions\user\POST;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService;
use api\services\AuthorizationService;

use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class RegisterAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $body = $rq->getParsedBody();

        try {
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }

            if (empty($body['username']) || empty($body['email']) || empty($body['password']) || empty($body['biography']) || empty($body['role'])) {
                throw new \Exception("Missing properties");
            }
            if (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Invalid email");
            }

            $properties = [
                'fullname' => empty($body['fullname']) ? '' : $body['fullname'],
                'username' => empty($body['username']) ? '' : $body['username'],
                'email' => $body['username'],
                'password' => password_hash($body['password'], PASSWORD_BCRYPT, ['cost' => 12]),
                'biography' => empty($body['biography']) ? 'Hello Scudo !' : $body['biography'],
                'phone' => empty($body['phone']) ? '' : $body['phone'],
                'image' =>  '',
                'role' => $body['role']
            ];

            $user = UserService::register($properties);
            $token = AuthorizationService::createAuthorization($user)->token;
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
        }

        $data = [
            'user' => FormatterObject::formatUser($user),
            'token' => $token
        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }
}
