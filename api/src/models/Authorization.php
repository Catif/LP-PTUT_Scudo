<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Authorization extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'Authorization';
  protected  $primaryKey = 'token';

  public $timestamps = true;

  public function user()
  {
    return $this->belongsTo('api\models\User', 'id_user');
  }
}
