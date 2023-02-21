<?php

namespace api\services;


use api\models\Group as Group;
use api\models\User;
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
      new \Exception("Le groupe n'a pas été trouvé.");
    }

    return $group;
  }

  static public function insertGroup($user, array $property)
  {
    if (empty($property['name']) || empty($property['description']) || empty($property['image'])) {
      throw new \Exception("un ou plusieur parametre n'existe pas quand on veut ajouter un groupe");
    }
    $modelsGroup = new Group();
    $modelsGroup->id_group = Uuid::uuid4()->toString();
    $modelsGroup->name = $property['name'];
    $modelsGroup->description = $property['description'];
    $modelsGroup->image = $property['image'];

    try {
      $modelsGroup->save();
    } catch (\Exception $e) {
      echo ($e->getMessage());
      throw new \Exception("Erreur d'enregistrement un groupe");
    }
    $modelsGroup->users()->attach($user, ['role' => 'owner']);

    return $modelsGroup;
  }

  static public function updateGroup(Group $group, array $property)
  {
    $group->name = isset($property['name']) ? $property['name'] : $group->name;
    $group->description = isset($property['description']) ? $property['description'] : $group->description;
    $group->image = isset($property['image']) ? $property['image'] : $group->image;

    $group->save();
    return $group;
  }

  static public function getResource(int $id, int $page, int $nbMax)
  {

    try {
      $resources = Group::findOrFail($id)->resources()->skip(($page - 1) * $nbMax)->take($nbMax)->get();
    } catch (\Exception $e) {
      new \Exception("Erreur lors de recuperations des resources d'un groupe");
    }

    return $resources;
  }

  static public function insertGroupFollow(User $user, Group $groupToFollow)
  {

    if ($groupToFollow->users()->find($user->id_user)->pivot->role == 'owner') {
      throw new Exception("Vous ne pouvez pas vous abonner à un groupe que vous avez créé.");
    }

    if (GroupService::isFollowing($user, $groupToFollow)) {
      throw new Exception("Vous suivez déjà ce groupe.");
    }

    $groupToFollow->users()->attach($user, ['role' => 'member']);
  }

  static public function deleteGroupFollow(User $user, Group $groupToUnfollow)
  {

    if ($groupToUnfollow->users()->find($user->id_user)->pivot->role == 'owner') {
      throw new Exception("Vous ne pouvez pas supprimer votre abonnement à un groupe que vous avez créé.");
    }

    if (!GroupService::isFollowing($user, $groupToUnfollow)) {
      throw new Exception("Vous ne suivez pas ce groupe.");
    }

    $groupToUnfollow->users()->detach($user);
  }

  static public function isFollowing(User $user, Group $userToCheck)
  {
    $idUserFollow = $userToCheck->id_user;

    if ($user->follows()->where('id_user_followed', $idUserFollow)->exists()) {
      return true;
    }

    return false;
  }
}
