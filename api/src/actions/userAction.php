<?php

namespace api\actions;


use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;
use api\services\utils\FormatterAPI;

final class UserAction {

    
    public function __invoke(Request $rq, Response $rs, array $args) : Response
    {
        $userService = new UserService; 
        $orders = $userService->getUser();
        $data = ['type' => 'collection',
        'count'=> count($orders),
        'orders'=> $orders];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
} 