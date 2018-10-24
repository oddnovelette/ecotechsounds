<?php
namespace application\models\Blog;

use yii\db\ActiveQuery;

/**
 * Class PostQuery
 * @package application\models\Blog
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
}
