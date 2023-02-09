<?php

namespace api\models;
class User extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'User';
  protected  $primaryKey = 'id_user';
  
  public $timestamps = true;


  public function group(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Group', 'User_Group', 'id_group', 'id_user');
  }

  public function follow(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'User_Follow', 'id_user_follow', 'id_user');
  }
}