<?php

namespace api\actions\general\POST;

use api\models\Authorization;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use api\services\utils\FormatterAPI;
use api\services\utils\FormatterObject;
use Ramsey\Uuid\Uuid;

final class UploadAction
{
  public function __invoke(Request $rq, Response $rs, array $args): Response
  {
    $header = $rq->getHeaders();
    $files = $rq->getUploadedFiles();


    try {
      $token = Authorization::findOrFail($header['API-Token'][0]);
      $user = $token->user()->first();
      if (empty($files)) {
        throw new \Exception("Aucun fichier reçu.");
      }

      $file = $files['file'];
      if ($file->getError() !== UPLOAD_ERR_OK) {
        throw new \Exception("Erreur lors de l'upload du fichier.");
      }

      $FOLDER_OUTPUT = dirname(__DIR__, 4) . '/public/uploads/';

      $fileFullmedia = $file->getClientMediaType();
      $fileMediaExplode = explode('/', $fileFullmedia);

      if (count($fileMediaExplode) != 2) {
        throw new \Exception("Type de fichier non supporté.");
      }

      $fileType = $fileMediaExplode[0];

      if ($fileType == 'image') {
        $FOLDER_OUTPUT .= 'images/';
      } elseif ($fileType == 'video') {
        $FOLDER_OUTPUT .= 'videos/';
      } else {
        throw new \Exception("Type de fichier non supporté.");
      }

      if (!file_exists($FOLDER_OUTPUT)) {
        mkdir($FOLDER_OUTPUT, 0777, true);
      }

      $fileExtension = $fileMediaExplode[1];
      $uuid = Uuid::uuid4()->toString();
      $filename = $uuid . '.' . $fileExtension;
      $FOLDER_OUTPUT .= $filename;

      try {
        $file->moveTo($FOLDER_OUTPUT);
      } catch (\Exception $e) {
        var_dump($e->getMessage());
        throw new \Exception("Erreur lors de l'upload du fichier.");
      }

      $routeFile = str_replace(dirname(__DIR__, 4) . '/public', '', $FOLDER_OUTPUT);

      $data = [
        'result' => [
          'url' => "https://api.scudo.catif.me" . $routeFile,
          'file' => [
            'filename' => $filename,
            'type' => $fileType,
            'name' => $uuid,
            'extension' => $fileExtension,
          ]
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
