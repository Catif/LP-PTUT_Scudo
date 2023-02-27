<?php

namespace api\actions\resource\GET;

use api\models\Authorization;
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
        $headers = $rq->getHeaders();
        $query = $rq->getQueryParams();
        try {
            $token = Authorization::findOrFail($headers['Authorization'][0]);
            $user = $token->user()->first();

            $page = isset($query['page']) ? $query['page'] : 1;
            $limit = isset($query['limit']) ? $query['limit'] : 5;

            $resources = ResourceService::getResourcesHomePage($user, $page, $limit);

            $listResources = [];
            foreach ($resources as $resource) {
                $listResources[] = FormatterObject::formatResource($resource);
            }

            $data = [
                'count' => count($resources),

                'result' => [
                    'resources' => $listResources
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
