<?php
namespace application\forms\Blog;

use application\models\Blog\Tag;
use yii\base\Model;

/**
 * Class TagForm
 * @package application\forms\Blog
 */
class TagForm extends Model
{
    public $name, $slug;
    private $_tag;

    /**
     * TagForm constructor.
     * @param Tag|null $tag
     * @param array $config
     */
    public function __construct(Tag $tag = null, array $config = [])
    {
        if ($tag) {
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'match', 'pattern' => '#^[a-z0-9_-]{3,255}$#s', 'message' => 'Format: a-z with 0-9'],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null]
        ];
    }
}
