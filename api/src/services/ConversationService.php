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
        'is_established'
    ])->get()->toArray();
  }

  public function getConversationByID($id): ?array
  {
    try {
      $order = Conversation::select([
        'id_conversation',
        'id_sender',
        'id_recipient',
        'is_established'
      ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        new Exception("error UserByID");
    }

    return $order->toArray();
  }
}