<?php

namespace api\models;

class Comment extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Comment';
  protected  $primaryKey = 'id_comment';
  
  public $timestamps = true;
  const UPDATED_AT = null;


}