<?php
namespace application\models\Blog;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
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

    public static function create($name, $slug) : self
    {
        $tag = new self();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug) : void
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName() : string
    {
        return '{{%blog_tags}}';
    }
}