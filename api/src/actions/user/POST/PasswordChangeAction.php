<?php
namespace api\actions\user\POST;

use api\models\Authorization;
use api\services\AuthorizationService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\UserService as UserService;

use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;

final class PasswordChangeAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $headers = $rq->getHeaders();
    $token = $headers['Authorization'][0];
    
    

    $body = $rq->getParsedBody();

    try {
      if (!is_array($body)) {
        throw new \Exception("Aucune information reçu.");
      }

      if (empty($body['old_password']) || empty($body['new_password']) || empty($body['new_password_repeat'])) {
        throw new \Exception("Les propriétés 'old_password', 'new_password' et 'new_password_repeat' sont obligatoires.");
      }
      if ($body['new_password'] != $body['new_password_repeat']) {
        throw new \Exception("Les mots de passe ne correspondent pas.");
      }

      if (strlen($body['new_password']) < 10) {
        throw new \Exception("Le mot de passe doit contenir au moins 10 caractères.");
      }
      if(!password_verify($body['old_password'],UserService::getPasswordChange($token))){
        throw new \Exception('Mot de passe incorrect.');
      }

      $passwordChange = UserService::passwordChange($token,$body['new_password']);

      $data = [

        'result' => [
          'user' => FormatterObject::formatUser($passwordChange),
          'change' => True,
          'token' => $token
        ]
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 201); // 201 = Created
    } catch (\Exception $e) {
      $data = [
        'error' => $e->getMessage()
      ];
      return FormatterAPI::formatResponse($rq, $rs, $data, 400); // 400 = Bad Request
    }
  }
}
