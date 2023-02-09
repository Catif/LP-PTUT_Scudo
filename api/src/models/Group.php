<?php

namespace api\models;

class Group extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Group';
  protected  $primaryKey = 'id_group';
  
  public $timestamps = true;


  public function resource(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Resource', 'Resource_Group', 'id_resource', 'id_group');
  }

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\User', 'User_Group', 'id_user', 'id_group');
  }
}