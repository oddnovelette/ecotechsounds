<?php
namespace application\services\Blog;

use application\forms\Blog\PostForm;
use application\models\Blog\{Category, Post, Tag};
use application\models\Meta;

/**
 * Class BlogService
 * @package application\services\Blog
 */
class BlogService
{

    public function create(PostForm $form) : Post
    {
        if (!$category = Category::findOne($form->categoryId)) {
            throw new \RuntimeException('Category is not found.');
        }
        $post = Post::create(
            $category->id,
            $form->title,
            $form->slug,
            $form->description,
            $form->language,
            $form->content,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords)
        );

        if ($form->photo) $post->setPhoto($form->photo);

        foreach ($form->tags->existing as $tagId) {
            if (!$tag = Tag::findOne($tagId)) {
                throw new \RuntimeException('Tag is not found.');
            }
            $post->assignTag($tag->id);
        }

        \Yii::$app->db->transaction(function () use ($post, $form) {

            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = Tag::findOne(['name' => $tagName])) {
                    $tag = Tag::create($tagName, $tagName);
                    if (!$tag->save()) {
                        throw new \RuntimeException('Tag saving error occured.');
                    }
                }
                $post->assignTag($tag->id);
            }
            if (!$post->save()) {
                throw new \RuntimeException('Post saving error.');
            }
        });
        return $post;
    }

    public function edit($id, PostForm $form) : void
    {
        if (!$post = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        if (!$category = Category::findOne($form->categoryId)) {
            throw new \RuntimeException('Category is not found.');
        }
        $post->edit(
            $category->id,
            $form->title,
            $form->slug,
            $form->description,
            $form->language,
            $form->content,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords)
        );

        if ($form->photo) $post->setPhoto($form->photo);

        \Yii::$app->db->transaction(function () use ($post, $form) {

            $post->revokeTags();
            if (!$post->save()) {
                throw new \RuntimeException('Post saving error occured.');
            }

            foreach ($form->tags->existing as $tagId) {
                if (!$tag = Tag::findOne($tagId)) {
                    throw new \RuntimeException('Tag is not found.');
                }
                $post->assignTag($tag->id);
            }

            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = Tag::findOne(['name' => $tagName])) {
                    $tag = Tag::create($tagName, $tagName);
                    if (!$tag->save()) {
                        throw new \RuntimeException('Tag saving error occured.');
                    }
                }
                $post->assignTag($tag->id);
            }
            if (!$post->save()) {
                throw new \RuntimeException('Post saving error.');
            }
        });
        return;
    }

    public function publishPost($id) : void
    {
        if (!$post = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        $post->publish();

        if (!$post->save()) {
            throw new \RuntimeException('Post saving error occured.');
        }
    }

    public function draft($id) : void
    {
        if (!$post = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }
        $post->draft();
        if (!$post->save()) {
            throw new \RuntimeException('Post saving error occured.');
        }
    }

    public function remove($id) : void
    {
        if (!$post = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        if (!$post->delete()) {
            throw new \RuntimeException('Post deleting error occured.');
        }
        return;
    }
}
