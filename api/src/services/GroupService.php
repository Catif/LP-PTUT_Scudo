<?php

namespace api\services;


use api\models\Group as Group;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

final class GroupService
{
  static public function getGroups()
  {
    return Group::select([
      'id_group',
      'name',
      'description',
      'image',
      'created_at'
      ])->get();
  }

  static public function getGroupById($id)
  {
    try {
      $group = Group::select([
        'id_group',
        'name',
        'description',
        'image',
        'created_at'
      ])->findOrFail($id);
    } catch (\Exception $e) {
        new \Exception("erreur du service getGroupById");
    }

    return $group;
  }

  static public function insertGroup($user ,array $property)
  {
    if (empty($property['name']) || empty($property['description']) || empty($property['image'])) {
      throw new \Exception("un ou plusieur parametre n'existe pas quand on veut ajouter un groupe");
    }
    
    $modelsGroup= new Group();
    $modelsGroup->id_group = Uuid::uuid4()->toString();
    $modelsGroup->name = $property['name'];
    $modelsGroup->description = $property['description'];
    $modelsGroup->image = $property['image'];

    try {
      $modelsGroup->save();
      
    } catch (\Exception $e) {
      echo($e->getMessage());
      throw new \Exception("Erreur d'enregistrement un groupe");
    }
    $modelsGroup->users()->attach($user, ['role' => 'owner']);

    return $modelsGroup;
  }

  static public function insertGroupFollow(int $id_group, $id_user)
  {
    try {   
    $group = Group::find($id_group)->users()->attach($id_user, ['role' => 'member']);
  } catch (\Exception $e) {
    new \Exception("Erreur lors du follow d'un groupe");
  }
    return $group;
  }

  static public function updateGroup(int $id,array $property){
    if((empty($property['name']) || empty($property['description']) || empty($property['image']))){
      throw new \Exception("un champs n'a pas été remplis ou n'est pas intègre au nomage demandé");
    }
    $modelsGroup = Group::find($id);
    $modelsGroup->name = $property['name'];
    $modelsGroup->description = $property['description'];
    $modelsGroup->image = $property['image'];

    $modelsGroup->save();
    return $modelsGroup;
  }

  static public function getResource(int $id,int $page, int $nbMax){

    try {
      $group = Group::find($id)->resources()->skip(($page - 1)* $nbMax)->take($nbMax)->get();
    } catch (\Exception $e) {
        new \Exception("Erreur lors de recuperations des resources d'un groupe");
    }

    return $group;
  }

  static public function deleteGroupFollow(int $id_group, $id_user)
  {
    try{
    $group = Group::find($id_group)->users()->detach($id_user);
    }catch(\Exception $e){
      new \Exception("Erreur lors de l'unfollow d'un groupe");
    }

    return $group;
  }
}