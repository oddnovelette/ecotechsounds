<?php
namespace application\services\blog;

use application\models\Blog\Post;
use application\models\User;

class PostLikeService
{
    public function add($userId, $postId) : void
    {
        $user = User::findOne(['id' => $userId]);
        if (!$user) throw new \RuntimeException('User not found.');

        if (!$post = Post::findOne($postId)) throw new \RuntimeException('Post not found.');

        $user->submitPostLike($post->id);
        if (!$user->save()) throw new \RuntimeException('Like saving error occured.');
    }

    public function remove($userId, $postId) : void
    {
        $user = User::findOne(['id' => $userId]);
        if (!$user) throw new \RuntimeException('User not found.');

        if (!$post = Post::findOne($postId)) throw new \RuntimeException('Post not found.');

        $user->removeFromPostLikesList($post->id);
        if (!$user->save()) throw new \RuntimeException('Like saving error occured.');
    }
}
