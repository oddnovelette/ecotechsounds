<?php
namespace application\models\Store;

use application\behaviors\MetaTagsBehavior;
use application\models\Meta;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Meta $meta
 */
class Label extends ActiveRecord
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

    /**
     * Label named constructor
     * @param string $name
     * @param string $slug
     * @param Meta $meta
     * @return Label
     */
    public static function create(string $name, string $slug, Meta $meta) : self
    {
        $label = new self();
        $label->name = $name;
        $label->slug = $slug;
        $label->meta = $meta;
        return $label;
    }

    /**
     * @param string $name
     * @param string $slug
     * @param Meta $meta
     * @return void
     */
    public function edit(string $name, string $slug, Meta $meta) : void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->meta = $meta;
    }

    public static function tableName() : string
    {
        return '{{%store_labels}}';
    }
}
