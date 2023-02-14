<?php

namespace api\actions\group\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class GroupAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $groupService = new GroupService;
        $groups = $groupService->getGroups();
        $listGroup = [];
        foreach($groups as $group){
            $listGroup[] =FormatterObject::formatGroup($group);
        }

        $data = [
            'type' => 'Table',
            'count' => count($listGroup),

            'User' => $listGroup
        ];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
}
