<?php
namespace application\services;

use application\forms\PageForm;
use application\models\{Page, Meta};

/**
 * Class PageService
 * @package application\services
 */
class PageService
{
    public function create(PageForm $form) : Page
    {
        $page = Page::create($form->title, $form->slug, $form->sort, $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        if (!$page->save()) {
            throw new \RuntimeException('Page saving error occured.');
        }
        return $page;
    }

    public function edit($id, PageForm $form) : void
    {
        if (!$page = Page::findOne($id)) {
            throw new \RuntimeException('Page is not found.');
        }

        $page->edit($form->title, $form->slug, $form->sort, $form->content,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if (!$page->save()) {
            throw new \RuntimeException('Page saving error occured.');
        }
        return;
    }

    public function remove($id) : void
    {
        if (!$page = Page::findOne($id)) {
            throw new \RuntimeException('Page not found.');
        }

        if (!$page->delete()) {
            throw new \RuntimeException('Page deleting error.');
        }
    }
}
