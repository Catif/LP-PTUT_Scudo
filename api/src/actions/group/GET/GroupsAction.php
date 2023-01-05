<?php

namespace api\actions\group\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class GroupsAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $groups = GroupService::getGroups();
        $listGroup = [];
        foreach ($groups as $group) {
            $listGroup[] = FormatterObject::formatGroup($group);
        }

        $data = [
            'count' => count($listGroup),
            'group' => $listGroup
        ];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
}
