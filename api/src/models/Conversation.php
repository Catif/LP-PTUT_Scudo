<?php

namespace api\models;

class Conversation extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'User';
  protected  $primaryKey = 'id_user';

  public $timestamps = false;

  public function resources(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Resource', 'Resource_Group', 'id_re', 'id_group');
  }

  public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'User_Group', 'id_user', 'id_group');
  }
}
