<?php

namespace api\models;

class Message extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'message';
  protected  $primaryKey = 'id_message';

  public $timestamps = true;
}
