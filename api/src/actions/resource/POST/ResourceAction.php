<?php

namespace api\actions\resource\POST;

use api\models\Authorization;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService;
use api\services\utils\FormatterAPI;
use Exception;

final class ResourceAction
{


    public function __invoke(Request $rq, Response $rs): Response
    {
        $headers = $rq->getHeaders();
        $body = $rq->getParsedBody();

        try {
            $token = Authorization::find($headers['API-Token'][0]);
            $properties = $this->formatResource($body);

            $user = $token->user()->first();

            $resource = ResourceService::insertResource($properties, $user);

            $data = [
                'request' => '/api/resource/' . $resource->id_resource,
                'result' => [
                    'resource' => $resource,
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
            throw new Exception("Missing parameters");
        }
        if ($body['type'] != 'video' && $body['type'] != 'stream' && $body['type'] != 'text') {
            throw new Exception("Invalid type of resource");
        }
    }

    private function formatResource($properties)
    {
        $this->validateBody($properties);

        switch ($properties['type']) {
            case 'video':
                $filename = 'video/test.mp4';
                break;
            case 'stream':
                $filename = '';
                break;
            case 'text':
                $filename = '';
            default:
                # code...
                break;
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
