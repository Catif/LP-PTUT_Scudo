<?php

namespace api\services;


use api\models\Conversation as Conversation;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ConversationService
{
  public function getConversation(): array
  {
    return Conversation::select([
        'id_conversation',
        'id_sender',
        'id_recipient',
        'isEstablished'
    ])->get()->toArray();
  }

  public function getConversationByID($id): ?array
  {
    try {
      $conversation = Conversation::select([
        'id_conversation',
        'id_sender',
        'id_recipient',
        'isEstablished'
      ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        new Exception("error getConversationById");
    }

    return $conversation->toArray();
  }
}