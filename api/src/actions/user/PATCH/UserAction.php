<?php

namespace api\actions\user\PATCH;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService;
use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class UserAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $data = [
      'message' => 'test'
    ];
    return FormatterAPI::formatResponse($rq, $rs, $data);
  }
}
