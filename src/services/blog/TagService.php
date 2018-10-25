<?php
namespace src\services\blog;

use src\forms\Blog\TagForm;
use src\models\Blog\Tag;
use yii\helpers\Inflector;

/**
 * Class TagService
 * @package src\services\blog
 */
class TagService
{
    public function create(TagForm $form) : Tag
    {
        $tag = Tag::create($form->name, $form->slug ?? Inflector::slug($form->name));
        if (!$tag->save()) {
            throw new \RuntimeException('Blog tag saving error occured.');
        }
        return $tag;
    }

    public function edit($id, TagForm $form) : void
    {
        if (!$tag = Tag::findOne($id)) {
            throw new \RuntimeException('Store tag is not found.');
        }

        $tag->edit($form->name, $form->slug ?? Inflector::slug($form->name));
        if (!$tag->save()) {
            throw new \RuntimeException('Blog tag saving error occured.');
        }
        return;
    }

    public function remove($id) : void
    {
        if (!$tag = Tag::findOne($id)) {
            throw new \RuntimeException('Blog tag is not found.');
        }

        if (!$tag->delete()) {
            throw new \RuntimeException('Blog tag removing error occured.');
        }
    }
}