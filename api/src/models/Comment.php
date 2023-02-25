<?php

namespace api\models;

class Comment extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'comment';
  protected  $primaryKey = 'id_comment';

  public $timestamps = true;
  const UPDATED_AT = null;

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo('api\models\User', 'id_user');
  }

  public function resource(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo('api\models\Resource', 'id_resource');
  }
}
