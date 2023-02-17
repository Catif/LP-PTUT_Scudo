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
            $this->validateProperties($body);
            $properties = $this->formatDefaultValues($body);

            $user = UserService::register($properties);
            $token = AuthorizationService::createAuthorization($user)->token;
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
        }

        $data = [

            'result' => [
                'user' => FormatterObject::formatUser($user),
                'token' => $token
            ]
        ];
        return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    }


    private function validateProperties(array $properties): void
    {
        if (!is_array($properties)) {
            throw new \Exception("Aucune information reçu.");
        }

        if (empty($properties['username']) || empty($properties['email']) || empty($properties['password']) || empty($properties['role'])) {
            throw new \Exception("Des champs sont manquantes.");
        }
        if (!filter_var($properties['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("L'email n'est pas valide.");
        }
    }


    private function formatDefaultValues($properties)
    {
        return [
            'fullname' => empty($properties['fullname']) ? '' : $properties['fullname'],
            'username' => $properties['username'],
            'email' => $properties['email'],
            'password' => password_hash($properties['password'], PASSWORD_BCRYPT, ['cost' => 12]),
            'biography' => 'Hello Scudo !',
            'phone' => empty($properties['phone']) ? '' : $properties['phone'],
            'image' =>  '',
            'role' => $properties['role']
        ];
    }
}
