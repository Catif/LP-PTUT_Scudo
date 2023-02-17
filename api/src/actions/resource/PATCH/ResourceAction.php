<?php

namespace api\actions\resource\PATCH;

use api\models\Authorization;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService as ResourceService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;
use Exception;

final class ResourceAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $header = $rq->getHeaders();
        $body = $rq->getParsedBody();
        if ($body == null) {
            $data = [
                'error' => 'Body is empty'
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400);
        }
        try {
            $token = Authorization::findOrFail($header['Authorization'][0]);
            $user = $token->user()->first();
            $resource = ResourceService::getResourceByID($args['id']);
            if ($resource->id_user != $user->id_user) {
                $data = [
                    'error' => 'You are not the owner of this resource'
                ];
                return FormatterAPI::formatResponse($rq, $rs, $data, 403);
            }
            $newResource = ResourceService::updateResource($resource, $body);
            $data = [
                'Resource' => FormatterObject::formatResource($newResource)
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
