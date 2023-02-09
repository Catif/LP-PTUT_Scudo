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
        new Exception("error UserByID");
    }

    return $message->toArray();
  }
}