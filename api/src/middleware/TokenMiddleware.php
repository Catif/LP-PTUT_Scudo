<?php

namespace api\middleware;

use api\models\Authorization;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class TokenMiddleware
{
  public function __invoke(Request $request, RequestHandler $handler): Response
  {
    $token = $this->getTokenFromRequest($request);

    if ($this->verifyToken($token)) {
      $response = $handler->handle($request);
      return $response;
    } else {
      $response = new Response();
      $data = [
        'error' => "Token invalide ou manquant."
      ];
      $response->getBody()->write(json_encode($data));
      return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
    }
  }

  private function getTokenFromRequest(Request $request)
  {
    $header = $request->getHeader('Authorization');
    if (empty($header)) {
      return null;
    } else {
      return $header[0];
    }
  }

  private function verifyToken($token)
  {
    if (empty($token)) {
      return false;
    }
    try {
      Authorization::findOrFail($token);
      return true;
    } catch (\Exception $e) {
      return false;
    }
  }
}
