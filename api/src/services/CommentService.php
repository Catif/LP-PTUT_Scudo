<?php

namespace api\services;


use api\models\Comment as Comment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class CommentService
{
  public function getComment(): array
  {
    return Comment::select([
      'id_comment',
      'id_user',
      'id_resource',
      'content',
      'created_at'
      ])->get()->toArray();
  }

  public function getCommentById($id): ?array
  {
    try {
      $comment = Comment::select([
        'id_comment',
        'id_user',
        'id_resource',
        'content',
        'created_at'
      ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        new Exception("error getCommentById");
    }

    return $comment->toArray();
  }
  
}