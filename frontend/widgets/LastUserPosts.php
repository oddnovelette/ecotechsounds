<?php

namespace frontend\widgets;

use src\models\Blog\Post;
use src\models\User;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Class LastUserPosts
 * @package frontend\widgets
 */
class LastUserPosts extends Widget
{
    public $user;
    public $limit = 10;

    public function init()
    {
        if (!$this->user || !$this->user instanceof User) {
            throw new InvalidConfigException('Empty post.');
        }
    }

    public function run()
    {
        return $this->render('last-user-posts', [
            'user' => $this->user,
            'posts' => Post::find()->forUser($this->user->id)->latest($this->limit)->all(),
        ]);
    }
}
