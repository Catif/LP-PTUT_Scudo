<?php

namespace api\actions\resource\GET;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\ResourceService as ResourceService;
use api\services\utils\FormatterAPI;

final class ResourceAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $comments = ResourceService::getResource();
        $data = [
            'Resource' => $comments
        ];

        return FormatterAPI::formatResponse($rq, $rs, $data);
    }
}
