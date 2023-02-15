<?php

namespace api\services;


use api\models\Group as Group;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GroupService
{
  static public function getGroup(): array
  {
    return Group::select([
      'id_group',
      'name',
      'description',
      'image',
      'created_at'
    ])->get()->toArray();
  }

  static public function getGroupById($id): Group
  {
    try {
      return Group::findOrFail($id);
    } catch (ModelNotFoundException $e) {
      new Exception("error getGroupById");
    }
  }

  static public function insertGroup(array $property)
  {
    if (empty($property['name']) || empty($property['description']) || empty($property['image'])) {
      throw new \Exception("Missing property");
    }

    $modelsGroup = new Group();
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
