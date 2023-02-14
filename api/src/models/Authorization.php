<?php

namespace api\models;

class Comment extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Authorization';
  protected  $primaryKey = 'token';
  
  public $timestamps = true;


}