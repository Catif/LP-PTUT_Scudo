<?php

namespace api\actions\resource\POST;

use api\models\Authorization;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;
use Exception;

final class ResourceAction
{
    public function __invoke(Request $rq, Response $rs): Response
    {
        $headers = $rq->getHeaders();
        $body = $rq->getParsedBody();

        try {
            $token = Authorization::find($headers['Authorization'][0]);
            $properties = $this->formatResource($body);

            $user = $token->user()->first();

            $resource = ResourceService::insertResource($properties, $user);

            $resourceFormated = FormatterObject::formatResource($resource);

            $data = [
                'request' => '/api/resource/' . $resource->id_resource,
                'result' => [
                    'resource' => $resourceFormated,
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

    private function validateBody($body)
    {
        if (!isset($body['title']) || !isset($body['text']) || !isset($body['type']) || !isset($body['is_private'])) {
            throw new Exception("Paramètres manquants");
        }
        if ($body['type'] != 'video' && $body['type'] != 'stream' && $body['type'] != 'text') {
            throw new Exception("Type de resource non reconnu");
        }
    }

    private function formatResource($properties)
    {
        $this->validateBody($properties);

        if ($properties['type'] == 'video') {
            if (!isset($properties['filename'])) {
                throw new Exception("Chemin du fichier manquant");
            }
        } else {
            $properties['filename'] = '';
        }

        return [
            'title' => $properties['title'],
            'text' => $properties['text'],
            'filename' => $properties['filename'],
            'type' => $properties['type'],
            'is_private' => $properties['is_private'],
        ];
    }
}
