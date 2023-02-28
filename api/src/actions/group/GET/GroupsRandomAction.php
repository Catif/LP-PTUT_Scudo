<?php

namespace api\actions\group\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class GroupsRandomAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $query = $rq->getQueryParams();

        try {
            var_dump($query);
            $groups = GroupService::getRandomGroups($query['limit']);
            $listGroup = [];
            foreach ($groups as $group) {
                $listGroup[] = FormatterObject::formatGroup($group);
            }

            $data = [
                'count' => count($listGroup),

                'result' => [
                    'groups' => $listGroup
                ]
            ];
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
        }

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
}
