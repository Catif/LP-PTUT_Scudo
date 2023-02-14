<?php

namespace api\services;


use api\models\Group as Group;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GroupService
{
  public function getGroups()
  {
    return Group::select([
      'id_group',
      'name',
      'description',
      'image',
      'created_at'
      ])->get();
  }

  public function getGroupById($id)
  {
    try {
      $group = Group::select([
        'id_group',
        'name',
        'description',
        'image',
        'created_at'
      ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        new Exception("error getGroupById");
    }

    return $group;
  }

  public function insertGroup(array $property)
  {
    if (empty($property['name']) || empty($property['description']) || empty($property['image'])) {
      throw new \Exception("Missing property");
    }

    $modelsGroup= new Group();
    $modelsGroup->name = $property['name'];
    $modelsGroup->description = $property['description'];
    $modelsGroup->image = $property['image'];

    try {
      $modelsGroup->save();
    } catch (\Exception $e) {
      throw new \Exception("Error while saving group");
    }

    return $modelsGroup;
  }
}