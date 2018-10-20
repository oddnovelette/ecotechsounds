<?php
namespace application\forms\Blog;

use yii\base\Model;

class CommentForm extends Model
{
    public $parentId, $text;

    public function rules() : array
    {
        return [
            [['text'], 'required'],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }
}
