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

  static public function getUsers($q, $pagination)
  {
    $users = User::where('username', 'LIKE', "%{$q}%")->orWhere("fullname", "LIKE", "%{$q}%")
      ->skip(($pagination['page'] - 1) * $pagination['limit'])->take($pagination['limit'])
      ->get();

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

  static public function getResourcesByUser($user, $page, $limit)
  {
    try {
      return $user->resources()->skip(($page - 1) * $limit)->take($limit)->get();
    } catch (Exception $e) {
      throw new \Exception("Aucune ressource trouvée.");
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
      echo ($e->getMessage());
      throw new \Exception("Erreur pendant la création de l'utilisateur.");
    }

    return $user;
  }

  static public function editUser(User $user, array $property)
  {
    if ($property['image'] != null) {
      $user->image = $property['image'];
    }
    if ($property['biography'] != null) {
      $user->biography = $property['biography'];
    }
    if ($property['password'] != null) {
      $user->password = password_hash($property['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    }
    if ($property['username'] != null) {
      $user->username = $property['username'];
    }


    try {
      $user->save();
    } catch (\Exception $e) {
      throw new \Exception("Erreur pendant la modification de l'utilisateur.");
    }

    return $user;
  }

  static public function follow(User $user, User $userToFollow)
  {
    $idUserFollow = $userToFollow->id_user;

    if ($user->id_user === $userToFollow->id_user) {
      throw new Exception("Vous ne pouvez pas vous suivre vous même.");
    }

    if (UserService::isFollowing($user, $userToFollow)) {
      throw new Exception("Vous suivez déjà cet utilisateur.");
    }

    $user->follows()->attach($idUserFollow);
  }

  static public function unfollow(User $user, User $userToUnfollow)
  {
    $idUserFollow = $userToUnfollow->id_user;

    if ($user->id_user === $userToUnfollow->id_user) {
      throw new Exception("Vous ne pouvez pas vous suivre vous même.");
    }

    if (!UserService::isFollowing($user, $userToUnfollow)) {
      throw new Exception("Vous ne suivez pas cet utilisateur.");
    }

    $user->follows()->detach($idUserFollow);
  }

  static public function isFollowing(User $user, User $userToCheck)
  {
    $idUserFollow = $userToCheck->id_user;

    if ($user->follows()->where('id_user_followed', $idUserFollow)->exists()) {
      return true;
    }

    return false;
  }
  static public function isUsernameExist($username)
  {
    $user = User::where('username', $username)->first();
    if ($user != null) {
      return true;
    }
    return false;
  }
  static public function isEmailExist($email)
  {
    $user = User::where('email', $email)->first();
    if ($user != null) {
      return true;
    }
    return false;
  }
}
