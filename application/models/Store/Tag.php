<?php
namespace application\models\Store;

use yii\db\ActiveRecord;

/**
 * Class Tag
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @package application\models\Store
 */
class Tag extends ActiveRecord
{
    public function behaviors() : array
    {
        return [
            [
                'class' => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable'=> false,
                'ensureUnique' => true
            ]
        ];
    }

    public static function create(string $name, string $slug) : self
    {
        $tag = new self();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit(string $name, string $slug) : void
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName() : string
    {
        return '{{%store_tags}}';
    }
}
