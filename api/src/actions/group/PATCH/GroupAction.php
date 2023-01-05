<?php

namespace api\actions\group\PATCH;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\GroupService as GroupService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class GroupAction
{
    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $body = $rq->getParsedBody();
        try {
            if (!is_array($body)) {
                throw new \Exception("Missing Body");
            }
            $modelGroup = GroupService::updateGroup($args['id'],$body);

            $data = [
                'group' => FormatterObject::formatGroup($modelGroup)
            ];
            return  FormatterAPI::formatResponse($rq, $rs, $data);// 201 = Created
        } catch (\Exception $e) {
            $data = [
                'error' => $e->getMessage()
            ];
            return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
            return $rs;
        }


    }
}
