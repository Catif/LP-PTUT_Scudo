<?php

namespace api\services;


use api\models\Conversation;
use Exception;
use Ramsey\Uuid\Uuid;

final class ConversationService{
  static public function insertConversation($user ,array $property)
  {
    if (empty($property['name']) || empty($property['description']) || empty($property['image'])) {
      throw new \Exception("un ou plusieur parametre n'existe pas quand on veut ajouter un groupe");
    }
    $modelsConversation = new Conversation();
    $modelsConversation->id_conversation = Uuid::uuid4()->toString();
    $modelsConversation->id_sender = $user->id_user;
    // $modelsConversation->recipient = $args[''];
    $modelsConversation->image = $property['image'];

    try {
      $modelsConversation->save();
      
    } catch (\Exception $e) {
      echo($e->getMessage());
      throw new \Exception("Erreur d'enregistrement un groupe");
    }
    $modelsConversation->users()->attach($user->id_user);

    return $modelsConversation;
  }

}