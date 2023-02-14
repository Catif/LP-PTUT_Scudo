<?php

namespace api\models;

class User extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'User';
  protected  $primaryKey = 'id_user';

  public $timestamps = true;


  public function groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Group', 'User_Group', 'id_group', 'id_user');
  }

  public function follows(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'User_Follow', 'id_user_follow', 'id_user');
  }

  public function resources(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany('api\models\Resource', 'id_user');
  }

  public function authorization()
  {
    return $this->hasOne('api\models\Authorization', 'id_user');
  }
}
