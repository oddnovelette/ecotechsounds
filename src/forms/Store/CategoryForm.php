<?php
namespace src\forms\Store;

use src\forms\Embedded;
use src\models\Store\Category;
use src\forms\MetaTagsForm;

/**
 * Class CategoryForm
 * @property MetaTagsForm $meta;
 * @package src\forms\Store
 */
class CategoryForm extends Embedded
{
    public $name, $slug, $title, $description, $sort;
    private $_category;

    public function __construct(Category $category = null, array $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->sort = $category->sort;
            $this->meta = new MetaTagsForm($category->meta);
            $this->_category = $category;
        } else {
            $this->meta = new MetaTagsForm();
            $this->sort = Category::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['name'], 'required'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['slug'], 'match', 'pattern' => '#^[a-z0-9_-]{3,255}$#s', 'message' => 'Format: a-z with 0-9'],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]
        ];
    }

    protected function internalForms() : array
    {
        return ['meta'];
    }
}
