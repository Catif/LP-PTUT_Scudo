<?php

namespace api\actions\resource\POST;

use api\models\Authorization;
use api\services\GroupService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;
use Exception;

final class ResourceGroupShareAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $headers = $rq->getHeaders();

        try {
            Authorization::findOrFail($headers['Authorization'][0]);

            $resource = ResourceService::getResourceByID($args['id_resource']);
            $group = GroupService::getGroupByID($args['id_group']);
            var_dump($args['id_group']);

            $group->resources()->attach($resource['resource']->id_resource);

            $data = [
                'result' => [
                    'result' => 'success',
                ]
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 201);
        } catch (Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400);
        }
    }
}
