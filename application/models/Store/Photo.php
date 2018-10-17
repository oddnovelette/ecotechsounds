<?php
namespace application\models\Store;

use application\services\WatermarkingService;
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
        return '{{%store_photos}}';
    }

    public function behaviors() : array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@uploadsRoot/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@uploads/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@uploadsRoot/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@uploads/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'store_list' => ['width' => 200, 'height' => 200],
                    'store_prod_main' => ['width' => 750, 'height' => 1000],
                    //'store_prod_main' => ['processor' => [new WatermarkingService(750, 1000, '@frontend/web/image/logo.png'), 'process']],
                    //'catalog_origin' => ['processor' => [new WatermarkingService(1024, 768, '@frontend/web/image/logo.png'), 'process']],
                    'store_prod_additional' => ['width' => 80, 'height' => 80],
                ],
            ],
        ];
    }
}
