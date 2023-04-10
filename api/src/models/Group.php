<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Group extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'group';
  protected  $primaryKey = 'id_group';

  public $timestamps = true;


  public function resources(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Resource', 'resource_group', 'id_resource', 'id_group');
  }

  public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'user_group', 'id_group', 'id_user');
  }
}
