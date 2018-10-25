<?php
namespace src\services\Store;

use src\forms\Store\Product\PhotosForm;
use src\models\Meta;
use src\models\Store\Category;
use src\models\Store\Label;
use src\models\Store\Product;
use src\forms\Store\Product\ProductForm;
use src\models\Store\Tag;

class ProductService
{

    public function create(ProductForm $form) : Product
    {
        if (!$label = Label::findOne($form->labelId)) {
            throw new \RuntimeException('Label is not found.');
        }

        if (!$category = Category::findOne($form->categoryId)) {
            throw new \RuntimeException('Category is not found.');
        }

        $product = Product::create(
            $label->id,
            $category->id,
            $form->code,
            $form->name,
            $form->description,
            $form->price,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords)
        );

        foreach ($form->photos->files as $file) {
            $product->addPhoto($file);
        }

        foreach ($form->tags->existing as $tagId) {
            if (!$tag = Tag::findOne($tagId)) {
                throw new \RuntimeException('Tag is not found.');
            }
            $product->assignTag($tag->id);
        }

        \Yii::$app->db->transaction(function () use ($product, $form) {
            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = Tag::findOne(['name' => $tagName])) {
                    $tag = Tag::create($tagName, $tagName);

                    if (!$tag->save()) {
                        throw new \RuntimeException('Tag saving error.');
                    }
                }
                $product->assignTag($tag->id);
            }

            if (!$product->save()) {
                throw new \RuntimeException('Product saving error.');
            }
        });

        return $product;
    }

    public function edit($id, ProductForm $form) : void
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }

        if (!$label = Label::findOne($form->labelId)) {
            throw new \RuntimeException('Label is not found.');
        }

        if (!$category = Category::findOne($form->categoryId)) {
            throw new \RuntimeException('Category is not found.');
        }
        $product->edit(
            $label->id,
            $category->id,
            $form->code,
            $form->name,
            $form->description,
            $form->price,
            new Meta($form->meta->title, $form->meta->description, $form->meta->keywords)
        );

        \Yii::$app->db->transaction(function () use ($product, $form) {

            $product->revokeTags();
            if (!$product->save()) {
                throw new \RuntimeException('Product saving error.');
            }

            foreach ($form->tags->existing as $tagId) {
                if (!$tag = Tag::findOne($tagId)) {
                    throw new \RuntimeException('Tag is not found.');
                }
                $product->assignTag($tag->id);
            }

            foreach ($form->tags->newNames as $tagName) {
                if (!$tag = Tag::findOne(['name' => $tagName])) {
                    $tag = Tag::create($tagName, $tagName);
                    if (!$tag->save()) {
                        throw new \RuntimeException('Tag saving error.');
                    }
                }
                $product->assignTag($tag->id);
            }
            if (!$product->save()) {
                throw new \RuntimeException('Product saving error.');
            }
        });
        return;
    }

    public function remove($id) : void
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }

        if (!$product->delete()) {
            throw new \RuntimeException('Product deleting error.');
        }
    }

    public function addPhotos($id, PhotosForm $form) : void
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }

        foreach ($form->files as $file) {
            $product->addPhoto($file);
        }

        if (!$product->save()) {
            throw new \RuntimeException('Product saving error.');
        }
    }

    public function movePhotoUp($id, $photoId) : void
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }

        $product->movePhotoUp($photoId);

        if (!$product->save()) {
            throw new \RuntimeException('Product saving error.');
        }
    }

    public function movePhotoDown($id, $photoId) : void
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }

        $product->movePhotoDown($photoId);

        if (!$product->save()) {
            throw new \RuntimeException('Product saving error.');
        }
    }

    public function removePhoto($id, $photoId) : void
    {
        if (!$product = Product::findOne($id)) {
            throw new \RuntimeException('Product is not found.');
        }

        $product->removePhoto($photoId);

        if (!$product->save()) {
            throw new \RuntimeException('Product saving error.');
        }
    }
}
