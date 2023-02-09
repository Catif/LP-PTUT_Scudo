<?php

namespace api\models;
use api\models\Group as Group;

class User extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'User';
  protected  $primaryKey = 'id_user';
  
  public $timestamps = true;





}
