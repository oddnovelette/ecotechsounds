<?php
namespace frontend\widgets\Blog;

use src\forms\Blog\CommentForm;
use src\models\Blog\Comment;
use src\models\Blog\Post;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Class CommentsWidget
 * @package frontend\widgets\Blog
 */
class BlogCommentsWidget extends Widget
{
    /**
     * @var Post
     */
    public $post;

    public function init() : void
    {
        if (!$this->post) {
            throw new InvalidConfigException('Specify the post.');
        }
    }

    public function run() : string
    {
        $form = new CommentForm();
        $comments = $this->post->getComments()
            ->orderBy(['parent_id' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
        $items = $this->treeRecursive($comments, null);
        return $this->render('comments/comment', [
            'post' => $this->post,
            'items' => $items,
            'commentForm' => $form,
        ]);
    }
    /**
     * @param Comment[] $comments
     * @param integer $parentId
     * @return CommentView[]
     */
    public function treeRecursive(&$comments, $parentId) : array
    {
        $items = [];
        foreach ($comments as $comment) {
            if ($comment->parent_id == $parentId) {
                $items[] = new CommentView($comment, $this->treeRecursive($comments, $comment->id));
            }
        }
        return $items;
    }
}
