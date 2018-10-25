<?php
namespace src\forms\Store;

use src\forms\Embedded;
use src\models\Store\Label;
use src\forms\MetaTagsForm;

/**
 * Class LabelForm
 * @package src\forms\Store
 * @property MetaTagsForm $meta;
 */
class LabelForm extends Embedded
{
    public $name, $slug;
    private $_label;

    /**
     * LabelForm constructor.
     * @param Label|null $label
     * @param array $config
     */
    public function __construct(Label $label = null, array $config = [])
    {
        if ($label) {
            $this->name = $label->name;
            $this->slug = $label->slug;
            $this->meta = new MetaTagsForm($label->meta);
            $this->_label = $label;
        } else {
            $this->meta = new MetaTagsForm();
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'match', 'pattern' => '#^[a-z0-9_-]{3,255}$#s', 'message' => 'Format: a-z with 0-9'],
            [['name', 'slug'], 'unique', 'targetClass' => Label::class, 'filter' => $this->_label ? ['<>', 'id', $this->_label->id] : null]
        ];
    }

    public function internalForms() : array
    {
        return ['meta'];
    }
}