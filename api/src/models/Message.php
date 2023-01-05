<?php

namespace api\models;

class Message extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Message';
  protected  $primaryKey = 'id_message';
  
  public $timestamps = true;


}