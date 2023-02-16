<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'Comment';
  protected  $primaryKey = 'id_comment';
  public $timestamps = true;
  const UPDATED_AT = null; // null, car la table n'a pas de colonne updated_at
}