<?php
namespace application\services\Blog;

use application\forms\Blog\CommentEditForm;
use application\forms\Blog\CommentForm;
use application\models\Blog\{Comment, Post};
use application\models\User;

class CommentService
{

    public function create($postId, $userId, CommentForm $form) : Comment
    {
        if (!$post = Post::findOne($postId)) {
            throw new \RuntimeException('Post not found.');
        }

        $user = User::findOne(['id' => $userId]);
        if (!$user) throw new \RuntimeException('User not found.');

        $comment = $post->addComment($user->id, $form->parentId, $form->text);
        if (!$post->save()) {
            throw new \RuntimeException('Post saving error occured.');
        }

        return $comment;
    }

    public function edit($postId, $id, CommentEditForm $form) : void
    {
        if (!$post = Post::findOne($postId)) {
            throw new \RuntimeException('Post not found.');
        }

        $post->editComment($id, $form->parentId, $form->text);
        if (!$post->save()) {
            throw new \RuntimeException('Post saving error occured.');
        }
    }

    public function activate($postId, $id) : void
    {
        if (!$post = Post::findOne($postId)) {
            throw new \RuntimeException('Post not found.');
        }

        $post->activateComment($id);
        if (!$post->save()) {
            throw new \RuntimeException('Post saving error occured.');
        }
    }

    public function remove($postId, $id) : void
    {
        if (!$post = Post::findOne($postId)) {
            throw new \RuntimeException('Post not found.');
        }

        $post->removeComment($id);
        if (!$post->save()) {
            throw new \RuntimeException('Post saving error occured.');
        }
    }
}
