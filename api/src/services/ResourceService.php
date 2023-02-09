<?php

namespace api\services;


use api\models\Resource as Resource;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ResourceService
{
  public function getResource(): array
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

  public function getResourceByID($id): ?array
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
}