<?php

namespace api\services;


use api\models\Comment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

final class CommentService
{

  static public function insertComment($user ,$resource, array $property)
  {


    try {
      if (empty($property['content'])) {
        throw new \Exception("Le commentaire est vide");
      }
      
      $modelsComment= new Comment();
      $modelsComment->id_comment = uuid::uuid4()->toString();
      $modelsComment->id_user = $user->id_user;
      $modelsComment->id_resource = $resource;
      $modelsComment->content = $property['content'];

      $modelsComment->save();

    } catch (\Exception $e) {
      echo($e->getMessage());
      throw new \Exception("Erreur d'enregistrement du commentaire");
    }
   

    return $modelsComment;
  }
  
}