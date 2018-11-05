<?php
namespace frontend\widgets\Blog;

use src\models\Blog\Post;
use yii\base\Widget;

class LastPostsWidget extends Widget
{
    public $limit;

    public function run() : string
    {
        return $this->render('last-posts', [
            'posts' => Post::getLast($this->limit)
        ]);
    }
}
