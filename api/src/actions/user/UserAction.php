<?php

namespace api\actions\user;


use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;
use api\services\utils\FormatterAPI;

final class UserAction {

    
    public function __invoke(Request $rq, Response $rs, array $args) : Response
    {
        $userService = new UserService; 
        $users = $userService->getUser();
        $data = ['type' => 'Table',
        'count'=> count($users),
        'User'=> $users];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
} 