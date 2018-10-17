<?php
namespace application\forms;

use application\models\Meta;
use yii\base\Model;

/**
 * Class MetaForm
 * @package application\forms
 */
class MetaTagsForm extends Model
{
    public $title, $description, $keywords;

    /**
     * MetaForm constructor.
     * @param Meta|null $meta
     * @param array $config
     */
    public function __construct(Meta $meta = null, array $config = [])
    {
        if ($meta) {
            $this->title = $meta->title;
            $this->keywords = $meta->keywords;
            $this->description = $meta->description;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['description', 'keywords'], 'string'],
        ];
    }
}