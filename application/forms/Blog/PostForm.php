<?php
namespace application\forms\Blog;

use application\forms\Embedded;
use application\forms\MetaTagsForm;
use application\models\Blog\Category;
use application\models\Blog\Post;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
/**
 * @property MetaTagsForm $meta
 * @property TagsForm $tags
 */
class PostForm extends Embedded
{
    public $categoryId;
    public $title;
    public $slug;
    public $description;
    public $language;
    public $content;
    public $photo;
    private $_post;

    public function __construct(Post $post = null, array $config = [])
    {
        if ($post) {
            $this->categoryId = $post->category_id;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->description = $post->description;
            $this->language = $post->language;
            $this->content = $post->content;
            $this->meta = new MetaTagsForm($post->meta);
            $this->tags = new TagsForm($post);
            $this->_post = $post;
        } else {
            $this->meta = new MetaTagsForm();
            $this->tags = new TagsForm();
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['categoryId', 'title', 'language'], 'required'],
            [['title', 'language'], 'string', 'max' => 255],
            [['title', 'slug'], 'unique', 'targetClass' => Post::class, 'filter' => $this->_post ? ['<>', 'id', $this->_post->id] : null],
            [['categoryId'], 'integer'],
            [['description', 'content'], 'string'],
            [['photo'], 'image'],
        ];
    }

    public static function languageList() : array
    {
        return [
            Post::POST_LANG_EN => 'English',
            Post::POST_LANG_RU => 'Russian',
        ];
    }

    public function categoriesList() : array
    {
        return ArrayHelper::map(Category::find()->orderBy('sort')->asArray()->all(), 'id', 'name');
    }

    protected function internalForms() : array
    {
        return ['meta', 'tags'];
    }

    public function beforeValidate() : bool
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }
}
