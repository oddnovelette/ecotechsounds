<?php
namespace src\models\Store;

use src\behaviors\MetaTagsBehavior;
use src\models\Meta;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package src\models\Store
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
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

    public static function create(string $name, string $slug, string $title, string $description, int $sort, Meta $meta) : self
    {
        $category = new self();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->sort = $sort;
        $category->meta = $meta;
        return $category;
    }

    public function edit(string $name, string $slug, string $title, string $description, int $sort, Meta $meta) : void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->sort = $sort;
        $this->meta = $meta;
        return;
    }

    public function getSeoTitle() : string
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile() : string
    {
        return $this->title ?: $this->name;
    }

    public static function tableName() : string
    {
        return '{{%store_categories}}';
    }
}
