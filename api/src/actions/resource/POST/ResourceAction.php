<?php

namespace api\actions\resource\POST;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService;
use api\services\utils\FormatterAPI;

final class ResourceAction
{


    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $resourceService = new ResourceService;
        $body = $rq->getParsedBody();
        $resourceInsert = $resourceService->insertResource($body);

        $rs->getBody()->write(json_encode($resourceInsert));

        return $rs;
    }
}
