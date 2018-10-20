<?php
namespace frontend\widgets\Blog;

use application\models\Blog\Comment;

class CommentView
{
    public $comment;
    /**
     * @var self[]
     */
    public $children;

    public function __construct(Comment $comment, array $children)
    {
        $this->comment = $comment;
        $this->children = $children;
    }
}
