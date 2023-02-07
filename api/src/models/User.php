<?php

namespace api\models;

class User extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'User';
  protected  $primaryKey = 'id_user';
  
  public $timestamps = true;

  public function Conversation(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\api\models\Conversation', 'id_conversation', 'id_conversation', 'id_sender');
  }
}