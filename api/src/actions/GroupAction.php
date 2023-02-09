<?php

namespace api\actions;


use Psr\Http\Message\ResponseInterface as Response ;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;

final class GroupAction {

    
    public function __invoke(Request $rq, Response $rs, array $args) : Response
    {
        $groupService = new GroupService; 
        $group = $groupService->getGroup();
        $data = ['type' => 'Table',
        'count'=> count($group),
        'Group'=> $group];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
} 