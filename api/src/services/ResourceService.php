<?php

namespace api\services;

use api\errors\exceptions\RessourceNotFoundException;
use Ramsey\Uuid\Uuid;
use api\models\Resource;
use api\models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ResourceService
{
  static public function getResource(): array
  {
    return Resource::select([
      'id_resource',
      'id_user',
      'filename',
      'title',
      'text',
      'longitude',
      'latitude',
      'type',
      'is_private',
      'created_at',
      'updated_at',
      'published_at'
    ])->get()->toArray();
  }

  static public function getResourceByID($id): Resource
  {
    try {
      return Resource::findOrFail($id);
    } catch (Exception $e) {
      echo ($e->getMessage());
      throw new Exception("error UserByID");
    }
  }

  static public function insertResource(array $property, User $user)
  {
    $resource = new Resource();
    $resource->id_resource = Uuid::uuid4()->toString();
    $resource->filename = $property['filename'];
    $resource->title = $property['title'];
    $resource->text = $property['text'];
    $resource->type = $property['type'];
    $resource->is_private = $property['is_private'];

    if ($property['is_private'] == 0) {
      $resource->published_at = date('Y-m-d H:i:s');
    }

    $user->resources()->save($resource);

    return $resource;
  }

  static public function shareResourceToGroup($id_resource, $id_group)
  {
    $resource = Resource::findOrFail($id_resource);
    $resource->groups()->attach($id_group);
  }
}
