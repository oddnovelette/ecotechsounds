<?php
namespace backend\forms\Blog;

use application\helpers\PostHelper;
use application\models\Blog\{Category, Post};
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class PostSearch extends Model
{
    public $id;
    public $title;
    public $status;
    public $language;
    public $category_id;

    public function rules() : array
    {
        return [
            [['id', 'status', 'category_id',], 'integer'],
            [['title', 'language'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params) : ActiveDataProvider
    {
        $query = Post::find();
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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'language', $this->language]);
        return $dataProvider;
    }

    public function languageList() : array
    {
        return PostHelper::languageList();
    }

    public function categoriesList() : array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    public function statusList() : array
    {
        return PostHelper::statusList();
    }
}
