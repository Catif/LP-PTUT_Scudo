<?php

namespace api\models;

class Conversation extends \Illuminate\Database\Eloquent\Model
{

  protected  $table = 'Conversation';
  protected  $primaryKey = 'id_conversation';
  
  public $timestamps = false;

//   public function mots_clefs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
//   {
//     return $this->belongsToMany('\iutnc\tucapp\model\Mots_Clefs', 'mots_clefs_galeries', 'id_galerie', 'mot_clef');
//   }

//   public function utilisateurs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
//   {
//     return $this->belongsToMany('\iutnc\tucapp\model\Utilisateurs', 'utilisateurs_galeries', 'id_galerie','id_utilisateur');
//   }

//   public function photos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
//   {
//     return $this->belongsToMany('\iutnc\tucapp\model\Photos', 'galeries_photos', 'id_galerie', 'id_photo');
//   }
}