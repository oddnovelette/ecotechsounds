<?php
namespace src\services\Blog;

use src\forms\Blog\{PostForm, PhotosForm};
use src\models\Blog\{Category, Post, Tag};
use src\models\Meta;

/**
 * Class BlogService
 * @package src\services\Blog
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

        foreach ($form->photos->files as $file) {
            $post->addPhoto($file);
        }

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

    public function addPhotos($id, PhotosForm $form) : void
    {
        if (!$product = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }

        if (!$product->save()) {
            throw new \RuntimeException('Post saving error.');
        }
    }

    public function movePhotoUp($id, $photoId) : void
    {
        if (!$product = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        $product->movePhotoUp($photoId);

        if (!$product->save()) {
            throw new \RuntimeException('Post saving error.');
        }
    }

    public function movePhotoDown($id, $photoId) : void
    {
        if (!$product = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        $product->movePhotoDown($photoId);

        if (!$product->save()) {
            throw new \RuntimeException('Post saving error.');
        }
    }

    public function removePhoto($id, $photoId) : void
    {
        if (!$product = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }

        $product->removePhoto($photoId);

        if (!$product->save()) {
            throw new \RuntimeException('Post saving error.');
        }
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
