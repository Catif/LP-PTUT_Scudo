<?php

namespace api\models;

class Resource extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Resource';
  protected  $primaryKey = 'id_resource';
  
  public $timestamps = true;


}