<?php
namespace src\models\Blog;

use yii\db\ActiveRecord;

/**
 * Class TagAssignment
 * @property integer $post_id;
 * @property integer $tag_id;
 * @package src\models\Blog
 */
class TagAssignment extends ActiveRecord
{
    public static function create($tagId) : self
    {
        $assignment = new self();
        $assignment->tag_id = $tagId;
        return $assignment;
    }

    public function isForTag($id) : bool
    {
        return $this->tag_id == $id;
    }

    public static function tableName() : string
    {
        return '{{%blog_tag_assignments}}';
    }
}
