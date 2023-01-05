<?php

namespace api\services;


use api\models\Message as Message;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class MessageService
{
  public function getMessage(): array
  {
    return Message::select([
        'id_message',
        'id_user',
        'id_conversation',
        'content',
        'created_at'
    ])->get()->toArray();
  }

  public function getMessageByID($id): ?array
  {
    try {
      $message = Message::select([
        'id_message',
        'id_user',
        'id_conversation',
        'content',
        'created_at'
      ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        new Exception("error MessageByID");
    }

    return $message->toArray();
  }

  public function insertMessage(array $property)
  {
    if (empty($property['id_user']) || empty($property['id_conversation']) || empty($property['content'])) {
      throw new \Exception("Missing property");
    }

    $modelsMessage = new Message();
    $modelsMessage->id_user = $property['id_user'];
    $modelsMessage->id_conversation = $property['id_conversation'];
    $modelsMessage->content = $property['content'];

    try {
      $modelsMessage->save();
    } catch (\Exception $e) {
      throw new \Exception("Error while saving message");
    }

    return $modelsMessage;
  }

}