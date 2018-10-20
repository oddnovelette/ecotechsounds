<?php
namespace application\forms\Blog;

use application\forms\Embedded;
use application\forms\MetaTagsForm;
use application\models\Blog\Category;

class CategoryForm extends Embedded
{
    public $name, $slug, $sort;
    private $_category;

    public function __construct(Category $category = null, array $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
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
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'match', 'pattern' => '#^[a-z0-9_-]{3,255}$#s', 'message' => 'Format: a-z with 0-9'],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]
        ];
    }

    public function internalForms() : array
    {
        return ['meta'];
    }
}