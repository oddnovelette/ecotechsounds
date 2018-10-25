<?php

namespace src\models;

use src\behaviors\MetaTagsBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property int $sort
 * @property string $content
 * @property Meta $meta
 */
class Page extends ActiveRecord
{
    public $meta;

    public static function create($title, $slug, $sort, $content, Meta $meta) : self
    {
        $page = new self();
        $page->title = $title;
        $page->slug = $slug;
        $page->sort = $sort;
        $page->content = $content;
        $page->meta = $meta;
        return $page;
    }

    public function edit($title, $slug, $sort, $content, Meta $meta) : void
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->sort = $sort;
        $this->content = $content;
        $this->meta = $meta;
    }

    public function getSeoTitle() : string
    {
        return $this->meta->title ?: $this->title;
    }

    public static function tableName() : string
    {
        return '{{%pages}}';
    }

    public function behaviors() : array
    {
        return [
            [
                'class' => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'immutable'=> false,
                'ensureUnique' => true
            ],
            MetaTagsBehavior::class,
        ];
    }

    public function transactions() : array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}
