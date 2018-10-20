<?php
namespace application\services\store;

use application\models\Meta;
use application\models\Store\Category;
use application\forms\store\CategoryForm;
use application\models\Store\Product;

/**
 * Class CategoryService
 * @package application\services\store
 */
class CategoryService
{
    public function create(CategoryForm $form) : Category
    {
        $category = Category::create(
            $form->name, $form->slug, $form->title, $form->description, $form->sort,
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

        $category->edit($form->name, $form->slug, $form->title, $form->description, $form->sort,
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

        if ($this->existsByCategory($category->id)) {
            throw new \DomainException('Unable to remove category with products.');
        }

        if (!$category->delete()) {
            throw new \RuntimeException('Category deleting error.');
        }
    }

    public function existsByCategory($id) : bool
    {
        return Product::find()->andWhere(['category_id' => $id])->exists();
    }
}
