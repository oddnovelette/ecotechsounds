<?php
namespace src\forms\Store\Product;

use yii\db\ActiveRecord;

/**
 * Class TagAssignment
 *
 * @property integer $product_id;
 * @property integer $tag_id;
 * @package src\models\Store\Product
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
        return '{{%store_tag_assignments}}';
    }
}