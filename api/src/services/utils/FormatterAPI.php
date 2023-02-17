<?php

namespace api\services\utils;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FormatterAPI
{
  public static function formatResponse(Request $rq, Response $rs, $data, $status = 200, $message = null): Response
  {
    $rs = $rs->withStatus($status);
    $rs = $rs->withHeader('Content-Type', 'application/json')
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Methods', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');

    $rs->getBody()->write(json_encode($data));

    return $rs;
  }
}