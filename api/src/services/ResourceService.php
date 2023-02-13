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

  public function insertResource(array $property)
  {
    $modelsUser = new Resource();
  
    $modelsUser->id_user = $property['id_user'];
    $modelsUser->filename = $property['filename'];
    $modelsUser->title = $property['title'];
    $modelsUser->text = $property['text'];
    $modelsUser->longitude = $property['longitude'];
    $modelsUser->latitude = $property['latitude'];
    $modelsUser->type = $property['type'];
    $modelsUser->is_private = $property['is_private'];

    $modelsUser->save();

    return $modelsUser;
  }

}