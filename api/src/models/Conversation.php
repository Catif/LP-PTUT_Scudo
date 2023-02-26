<?php

namespace api\models;

class Conversation extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'user';
  protected  $primaryKey = 'id_user';

  public $timestamps = false;

  public function resources(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Resource', 'resource_group', '', 'id_group');
  }
}
