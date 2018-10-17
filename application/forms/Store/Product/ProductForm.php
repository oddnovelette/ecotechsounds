<?php
namespace application\forms\Store\Product;

use application\forms\Embedded;
use application\forms\Store\CategoryForm;
use application\models\Store\Category;
use application\models\Store\Label;
use application\models\Store\Product;
use application\forms\MetaTagsForm;
use yii\helpers\ArrayHelper;

/**
 * Class ProductCreateForm
 * @package application\forms\Store
 *
 * @property MetaTagsForm $meta
 * @property CategoryForm $categories
 * @property PhotosForm $photos
 * @property TagsForm $tags
 */
class ProductForm extends Embedded
{
    public $labelId;
    public $categoryId;
    public $description;
    public $code;
    public $price;
    public $name;
    private $_product;

    public function __construct(Product $product = null, array $config = [])
    {
        if ($product) {
            $this->labelId = $product->label_id;
            $this->categoryId = $product->category_id;
            $this->code = $product->code;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->price = $product->price;
            $this->meta = new MetaTagsForm($product->meta);
            $this->tags = new TagsForm($product);
            $this->_product = $product;
        } else {
            $this->meta = new MetaTagsForm();
            $this->tags = new TagsForm();
            $this->photos = new PhotosForm();
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['labelId', 'name', 'price'], 'required'],
            [['code', 'name', 'description'], 'string', 'max' => 255],
            [['labelId', 'categoryId'], 'integer']
        ];
    }

    public function categoriesList() : array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    public function labelsList() : array
    {
        return ArrayHelper::map(Label::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms() : array
    {
        return ['meta', 'photos', 'tags'];
    }
}