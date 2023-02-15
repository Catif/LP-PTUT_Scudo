<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Conversation extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'User';
  protected  $primaryKey = 'id_user';

  public $timestamps = false;

  public function resources(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Resource', 'Resource_Group', 'id_group', 'id_resource');
  }
}
