<?php
namespace src\models\Blog;

use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file) : self
    {
        $photo = new self();
        $photo->file = $file;
        return $photo;
    }

    public function setSort($sort) : void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id) : bool
    {
        return $this->id == $id;
    }

    public static function tableName() : string
    {
        return '{{%post_photos}}';
    }

    public function behaviors() : array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@uploadsRoot/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@uploads/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@uploadsRoot/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 490],
                    'blog_list' => ['width' => 1000, 'height' => 600],
                    'widget_list' => ['width' => 300, 'height' => 300],
                    'origin' => ['width' => 1000, 'height' => 600],
                ],
            ],
        ];
    }
}
