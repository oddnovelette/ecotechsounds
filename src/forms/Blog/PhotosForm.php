<?php
namespace src\forms\Blog;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class PhotosForm used for posts
 * @package src\forms\Blog
 */
class PhotosForm extends Model
{

    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules() : array
    {
        return [
            ['files', 'each', 'rule' => ['image']],
        ];
    }

    public function beforeValidate() : bool
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');
            return true;
        }
        return false;
    }
}
