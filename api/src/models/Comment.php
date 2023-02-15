<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Comment extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;

  protected  $table = 'Comment';
  protected  $primaryKey = 'id_comment';
  
  public $timestamps = true;


}