<?php
namespace application\services\blog;

use application\models\Blog\Post;
use application\models\Meta;
use application\models\Blog\Category;
use application\forms\blog\CategoryForm;

/**
 * Class CategoryService
 * @package application\services\blog
 */
class CategoryService
{
    public function create(CategoryForm $form) : Category
    {
        $category = Category::create(
            $form->name, $form->slug, $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if (!$category->save()) {
            throw new \RuntimeException('Category saving error occured.');
        }
        return $category;
    }

    public function edit($id, CategoryForm $form) : void
    {
        if (!$category = Category::findOne($id)) {
            throw new \RuntimeException('Category is not found.');
        }

        $category->edit($form->name, $form->slug, $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if (!$category->save()) {
            throw new \RuntimeException('Category saving error occured.');
        }
        return;
    }

    public function remove($id) : void
    {
        if (!$category = Category::findOne($id)) {
            throw new \RuntimeException('Category is not found.');
        }

        if (Post::find()->andWhere(['category_id' => $id])->exists()) {
            throw new \DomainException('Unable to remove category with posts.');
        }

        if (!$category->delete()) {
            throw new \RuntimeException('Category deleting error.');
        }
    }
}
