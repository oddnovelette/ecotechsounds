<?php
namespace src\forms\Blog;

use src\models\Blog\Comment;
use yii\base\Model;

/**
 * Class CommentEditForm
 * @package src\forms\Blog
 */
class CommentEditForm extends Model
{
    public $parentId, $text;

    public function __construct(Comment $comment, array $config = [])
    {
        $this->parentId = $comment->parent_id;
        $this->text = $comment->text;
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['text'], 'required'],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }
}
