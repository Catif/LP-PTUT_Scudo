<?php

namespace api\actions\resource\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService as ResourceService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;
use Exception;

final class ResourcesAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $query = $rq->getQueryParams();
        try {
            $page = isset($query['page']) ? $query['page'] : 1;
            $limit = isset($query['limit']) ? $query['limit'] : 5;
            $resources = ResourceService::getResources($page, $limit);

            $listResources = [];
            foreach ($resources as $resource) {
                $listResources[] = FormatterObject::formatResource($resource);
            }

            $data = [
                'count' => count($resources),

                'result' => [
                    'Resource' => $listResources
                ]
            ];

            return FormatterAPI::formatResponse($rq, $rs, $data);
        } catch (Exception  $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 404);
        }
    }
}
