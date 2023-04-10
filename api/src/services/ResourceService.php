<?php

namespace api\services;

use api\errors\exceptions\RessourceNotFoundException;
use Ramsey\Uuid\Uuid;
use api\models\Resource;
use api\models\User;
use api\services\utils\FormatterObject;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class ResourceService
{
  static public function getResources($page, $limit)
  {
    return Resource::where('is_private', 0)->skip(($page - 1) * $limit)->take($limit)->get();
  }

  static public function getResourceByID($id): array
  {
    try {
      $resourceComment = Resource::findOrFail($id)->comments()->get();
      $resource = Resource::findOrFail($id);

      return [
        'resource' => $resource,
        'comment' => $resourceComment
      ];
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

  static public function updateResource(Resource $resource, array $properties)
  {
    $changed = false;
    if (isset($properties['is_private'])) {
      if ($properties['is_private'] == 0 && $resource->is_private == 1) {
        $resource->published_at = date('Y-m-d H:i:s');
        $resource->is_private = 0;
        $changed = true;
      } elseif ($properties['is_private'] == 1 && $resource->is_private == 0) {
        $resource->published_at = null;
        $resource->is_private = 1;
        $changed = true;
      }
    }
    if (isset($properties['filename'])) {
      $resource->filename = $properties['filename'];
      $changed = true;
    }
    if (isset($properties['type'])) {
      $resource->type = $properties['type'];
      $changed = true;
    }
    if (isset($properties['title'])) {
      $resource->title = $properties['title'];
      $changed = true;
    }
    if (isset($properties['text'])) {
      $resource->text = $properties['text'];
      $changed = true;
    }

    if (!$changed) {
      throw new Exception('No properties to update');
    }

    try {
      $resource->save();
    } catch (Exception $e) {
      throw new Exception('Error while saving resource with new properties');
    }
    return $resource;
  }
}
