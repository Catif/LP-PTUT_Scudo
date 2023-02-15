<?php

namespace api\services;


use Ramsey\Uuid\Uuid;
use api\models\Resource as Resource;
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

  static public function getResourceByID($id): ?array
  {
    try {
      $resource = Resource::select([
        'id_resource',
        'filename',
        'title',
        'text',
        'longitude',
        'latitude',
        'type',
        'isPrivate',
        'created_at',
        'update_at',
        'published_at'
      ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
      new Exception("error UserByID");
    }

    return $resource->toArray();
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

    $resource->save();

    $user->resources()->save($resource);

    return $resource;
  }
}
