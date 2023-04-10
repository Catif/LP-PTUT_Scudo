<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Authorization extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'authorization';
  protected  $primaryKey = 'token';

  public $timestamps = true;
  const UPDATED_AT = null; // null, car la table n'a pas de colonne updated_at

  public function user()
  {
    return $this->belongsTo('api\models\User', 'id_user');
  }
}
