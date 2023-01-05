<?php

namespace api\services\utils;

use api\models\User;
use api\models\Resource;
use api\models\Comment;
use api\models\Group;
use api\models\Conversation;
use api\models\Message;


class FormatterObject
{
  static function formatUser(User $user): array
  {
    return [
      'id' => $user['id_user'],
      'url' => [
        'api' => '/api/user/' . $user['id_user'],
        'image' => $user['image'],
      ],
      'fullname' => $user['fullname'],
      'username' => $user['username'],
      'email' => $user['email'],
      'biography' => $user['biography'],
      'phone' => $user['phone'],
      'role' => $user['role'],
      'created_at' => $user['created_at'],
    ];
  }

  static function formatUserWithResources(User $user, array $resources): array
  {
    $formatedResources = [];
    foreach ($resources as $resource) {
      $formatedResources[] = self::formatResource($resource);
    }

    return [
      'user' => self::formatUser($user),
      'resources' => $formatedResources,
    ];
  }

  static function formatUserWithGroups(User $user, array $groups): array
  {
    $formatedGroups = [];
    foreach ($groups as $group) {
      $formatedGroups[] = self::formatGroup($group);
    }

    return [
      'user' => self::formatUser($user),
      'groups' => $formatedGroups,
    ];
  }

  static function formatUserWithGroupsWithResources(User $user, array $groups, array $resources): array
  {
    $formatedGroups = [];
    foreach ($groups as $group) {
      $formatedGroups[] = self::formatGroup($group);
    }

    $formatedResources = [];
    foreach ($resources as $resource) {
      $formatedResources[] = self::formatResource($resource);
    }


    return [
      'user' => self::formatUser($user),
      'groups' => $formatedGroups,
      'resources' => $formatedResources,
    ];
  }

  static function formatResource(Resource $resource): array
  {
    return [
      'id' => $resource['id_resource'],
      'type' => $resource['type'],
      'urls' => [
        'api' => '/api/resource/' . $resource['id_resource'],
        'file' => $resource['filename']
      ],
      'title' => $resource['title'],
      'description' => $resource['text'],
      'localisation' => [
        'latitude' => $resource['latitude'],
        'longitude' => $resource['longitude'],
      ],
      'created_at' => $resource['created_at'],
      'updated_at' => $resource['updated_at'],
      'published_at' => $resource['published_at'],
    ];
  }

  static function formatResourceWithComments(Resource $resource, array $comments): array
  {
    $formatedComments = [];
    foreach ($comments as $comment) {
      $formatedComments[] = self::formatComment($comment);
    }

    return [
      'resource' => self::formatResource($resource),
      'comments' => $formatedComments,
    ];
  }

  static function formatComment(Comment $comment): array
  {
    return [
      'id' => $comment['id_comment'],
      'id_user' => $comment['id_user'],
      'text' => $comment['content'],
      'created_at' => $comment['created_at'],
    ];
  }

  static function formatGroup(Group $group): array
  {
    return [
      'id' => $group['id_group'],
      'url' => [
        'api' => '/api/group/' . $group['id_group'],
        'image' => $group['image'],
      ],
      'name' => $group['name'],
      'description' => $group['description'],
      'created_at' => $group['created_at'],
      'updated_at' => $group['updated_at'],
    ];
  }

  static function formatConversation(Conversation $conversation): array
  {
    return [
      'id' => $conversation['id_conversation'],
      'url' => [
        'api' => '/api/conversation/' . $conversation['id_conversation'],
        'image' => $conversation['image'],
      ],
    ];
  }

  static function formatConversationWithMessages(Conversation $conversation, array $messages): array
  {
    $formatedMessages = [];
    foreach ($messages as $message) {
      $formatedMessages[] = self::formatMessage($message);
    }

    return [
      'conversation' => self::formatConversation($conversation),
      'messages' => $formatedMessages,
    ];
  }

  static function formatMessage(Message $message): array
  {
    return [
      'id' => $message['id_message'],
      'id_user' => $message['id_user'],
      'text' => $message['content'],
      'created_at' => $message['created_at'],
    ];
  }
}
