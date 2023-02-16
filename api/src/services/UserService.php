<?php

namespace api\services;


use api\models\User as User;
use Exception;
use Ramsey\Uuid\Uuid;

final class UserService
{
  static public function exist($property): bool
  {
    if (!empty($property['email']) && !empty($property['username'])) {
      return User::where('email', $property['email'])->orWhere('username', $property['username'])->exists();
    }
    if (!empty($property['email'])) {
      return User::where('email', $property['email'])->exists();
    }
    if (!empty($property['username'])) {
      return User::where('username', $property['username'])->exists();
    }
    throw new \Exception("Email ou username non renseigné.");
  }

  static public function getUsers($q)
  {
    $users = User::select([
      'id_user',
      'fullname',
      'username',
      'email',
      'biography',
      'phone',
      'role',
      'created_at',
      'updated_at'
    ])->where('username', 'LIKE', "%{$q}%")->orWhere("fullname", "LIKE", "%{$q}%")->get();

    if ($users == null) {
      throw new \Exception("Aucun utilisateur trouvé.");
    }

    return $users;
  }

  static public function getUserByID($id): User
  {
    try {
      return User::findOrFail($id);
    } catch (Exception $e) {
      throw new \Exception("Utilisateur introuvable.");
    }
  }

  static public function getPassword($type, $username)
  {
    try {
      return User::select(['id_user', 'password'])->where($type, $username)->firstOrFail();
    } catch (Exception $e) {
      throw new \Exception("Utilisateur introuvable.");
    }
  }

  static public function register(array $property)
  {
    $user = new User();
    $user->id_user = Uuid::uuid4()->toString();
    $user->fullname = $property['fullname'];
    $user->username = $property['username'];
    $user->email = $property['email'];
    $user->password = $property['password'];
    $user->biography = $property['biography'];
    $user->phone = $property['phone'];
    $user->image = $property['image'];
    $user->role = $property['role'];

    try {
      $user->save();
    } catch (\Exception $e) {
      throw new \Exception("Erreur pendant la création de l'utilisateur.");
    }

    return $user;
  }

  static public function followUser(User $user, $id_user_follow)
  {
    $userFollow = UserService::getUserByID($id_user_follow);

    if ($user->id_user === $userFollow->id_user) {
      throw new Exception("Vous ne pouvez pas vous suivre vous même.");
    }

    if ($user->follows()->where('id_user_follow', $id_user_follow)->exists()) {
      throw new Exception("Vous suivez déjà cet utilisateur.");
    }

    $user->follows()->attach($id_user_follow);
  }

  static public function unfollowUser(User $user, $id_user_follow)
  {
    $userFollow = UserService::getUserByID($id_user_follow);

    if ($user->id_user === $userFollow->id_user) {
      throw new Exception("Vous ne pouvez pas vous suivre vous même.");
    }

    if (!$user->follows()->where('id_user_follow', $id_user_follow)->exists()) {
      throw new Exception("Vous ne suivez pas cet utilisateur.");
    }

    $user->follows()->detach($id_user_follow);
  }
}
