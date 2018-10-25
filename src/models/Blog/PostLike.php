<?php
namespace src\models\Blog;

use yii\db\ActiveRecord;

/**
 * Class PostLike
 * @property integer $user_id
 * @property integer $post_id
 *
 * @package src\models\Blog
 */
class PostLike extends ActiveRecord
{
    public static function create($postId) : self
    {
        $post_like = new self();
        $post_like->post_id = $postId;
        return $post_like;
    }

    public function isForPost($postId) : bool
    {
        return $this->post_id == $postId;
    }

    public static function tableName() : string
    {
        return '{{%user_post_likes}}';
    }

    public function behaviors() : array
    {
        return [
            'timestamp'=> [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'created_at',
            ]
        ];
    }
}
