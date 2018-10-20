<?php
namespace application\services\Store;

use application\models\Meta;
use application\models\Store\Label;
use application\forms\Store\LabelForm;

/**
 * Class LabelService
 * @package application\services\Store
 */
class LabelService
{
    /**
     * Creates a new store label
     * @param LabelForm $form
     * @return Label
     * @throws \RuntimeException
     */
    public function create(LabelForm $form) : Label
    {
        $label = Label::create($form->name, $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if (!$label->save()) {
            throw new \RuntimeException('Label saving error occured.');
        }
        return $label;
    }

    /**
     * Store label editing
     * @param int $id
     * @param LabelForm $form
     * @throws \RuntimeException
     */
    public function edit(int $id, LabelForm $form) : void
    {
        if (!$label = Label::findOne($id)) {
            throw new \RuntimeException('Label is not found.');
        }
        $label->edit($form->name, $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        if (!$label->save()) {
            throw new \RuntimeException('Label saving error occured.');
        }
        return;
    }

    /**
     * Removes store label
     * @param int $id
     * @return void
     * @throws \RuntimeException
     */
    public function remove(int $id) : void
    {
        if (!$label = Label::findOne($id)) {
            throw new \RuntimeException('Label is not found.');
        }

        if (!$label->delete()) {
            throw new \RuntimeException('Label deleting error occured.');
        }
    }
}