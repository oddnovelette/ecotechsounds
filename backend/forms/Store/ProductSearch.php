<?php
namespace backend\forms\Store;

use application\models\Store\Category;
use application\models\Store\Label;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use application\models\Store\Product;
use yii\helpers\ArrayHelper;

class ProductSearch extends Model
{
    public $id;
    public $code;
    public $name;
    public $price;
    public $category_id;
    public $label_id;

    public function rules() : array
    {
        return [
            [['id', 'category_id', 'label_id'], 'integer'],
            [['code', 'name', 'price'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params) : ActiveDataProvider
    {
        $query = Product::find()->with('mainPhoto', 'category');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'label_id' => $this->label_id,
            'price' => $this->price,
        ]);

        $query
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }

    public function categoriesList() : array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    public function labelsList() : array
    {
        return ArrayHelper::map(Label::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }
}
