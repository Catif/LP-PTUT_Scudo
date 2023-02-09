<?php

namespace api\services;


use api\models\Group as Group;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class GroupService
{
  public function getGroup(): array
  {
    return Group::select([
      'id_group',
      'name',
      'description',
      'image',
      'created_at'
      ])->get()->toArray();
  }

  public function getGroupById($id): ?array
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

    return $group->toArray();
  }
}