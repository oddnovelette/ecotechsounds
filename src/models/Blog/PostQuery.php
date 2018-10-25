<?php
namespace src\models\Blog;

use yii\db\ActiveQuery;

/**
 * Class PostQuery
 * @package src\models\Blog
 */
class PostQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function published($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Post::STATUS_PUBLISHED,
        ]);
    }

    public function forUser($userId)
    {
        return $this->andWhere(['user_id' => $userId]);
    }

    public function latest($limit)
    {
        return $this->limit($limit)->orderBy(['id' => SORT_DESC]);
    }
}
