<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'user';
  protected  $primaryKey = 'id_user';

  public $timestamps = true;


  public function groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Group', 'user_group', 'id_group', 'id_user');
  }

  public function follows(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'user_follow', 'id_user', 'id_user_followed');
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
