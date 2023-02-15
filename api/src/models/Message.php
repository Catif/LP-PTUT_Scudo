<?php

namespace api\models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Message extends \Illuminate\Database\Eloquent\Model
{
  use HasUuids;
  
  protected  $table = 'Message';
  protected  $primaryKey = 'id_message';
  
  public $timestamps = true;


}