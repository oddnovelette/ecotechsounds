<?php
namespace src\forms;

use src\models\Page;

/**
 * @property MetaTagsForm $meta;
 */
class PageForm extends Embedded
{
    public $title, $slug, $content, $sort;
    private $_page;

    public function __construct(Page $page = null, array $config = [])
    {
        if ($page) {
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->content = $page->content;
            $this->sort = $page->sort;
            $this->meta = new MetaTagsForm($page->meta);
            $this->_page = $page;
        } else {
            $this->meta = new MetaTagsForm();
            $this->sort = Page::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules() : array
    {
        return [
            [['title'], 'required'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['slug'], 'match', 'pattern' => '#^[a-z0-9_-]{3,255}$#s', 'message' => 'Format: a-z with 0-9'],
            [['slug'], 'unique', 'targetClass' => Page::class, 'filter' => $this->_page ? ['<>', 'id', $this->_page->id] : null]
        ];
    }

    public function internalForms() : array
    {
        return ['meta'];
    }
}
