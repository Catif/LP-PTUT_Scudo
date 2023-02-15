<?php

namespace api\models;

class Group extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Group';
  protected  $primaryKey = 'id_group';
  
  public $timestamps = true;


  public function resources(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Resource', 'Resource_Group', 'id_resource', 'id_group');
  }

  public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'User_Group', 'id_group', 'id_user');
  }
}