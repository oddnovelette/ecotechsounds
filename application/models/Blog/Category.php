<?php
namespace application\models\Blog;

use application\behaviors\MetaTagsBehavior;
use application\models\Meta;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property int $sort
 * @property Meta $meta
 */
class Category extends ActiveRecord
{
    public $meta;

    public function behaviors() : array
    {
        return [
            [
                'class' => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable'=> false,
                'ensureUnique' => true
            ],
            MetaTagsBehavior::class,
        ];
    }

    public static function create($name, $slug, $sort, Meta $meta) : self
    {
        $category = new self();
        $category->name = $name;
        $category->slug = $slug;
        $category->sort = $sort;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $slug, $sort, Meta $meta) : void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->sort = $sort;
        $this->meta = $meta;
        return;
    }

    public function getSeoTitle() : string
    {
        return $this->meta->title ?: $this->name;
    }

    public function getHeadingTile() : string
    {
        return $this->name;
    }

    public static function tableName() : string
    {
        return '{{%blog_categories}}';
    }
}
