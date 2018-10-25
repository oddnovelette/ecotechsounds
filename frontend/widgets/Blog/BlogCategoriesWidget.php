<?php
namespace frontend\widgets\Blog;

use src\models\Blog\Category;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class BlogCategoriesWidget
 * @package frontend\widgets\Blog
 */
class BlogCategoriesWidget extends Widget
{
    /** @var Category|null */
    public $active;

    public function run() : string
    {
        return Html::tag('span', implode(' / ', array_map(function (Category $category) {
            $active = $this->active && ($this->active->id == $category->id);
            return Html::a(
                Html::encode($category->name),
                ['/blog/post/category', 'slug' => $category->slug],
                ['class' => $active ? 'post-cat-active' : 'post-cat']
            );
        }, Category::find()->orderBy('sort')->all())), [
            'class' => 'post-cat-active',
        ]);
    }
}
?>
