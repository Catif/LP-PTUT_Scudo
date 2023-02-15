<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Resource extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'Resource';
  protected  $primaryKey = 'id_resource';

  public $timestamps = true;

  public function groups(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('api\models\Group', 'Resource_Group', 'id_group', 'id_resource');
  }

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo('api\models\User', 'id_user');
  }
}
