<?php

/* @var $item \frontend\widgets\Blog\CommentView */

use yii\bootstrap\Html;
use yii\helpers\Url;

?>
<div class="comment-item" data-id="<?= $item->comment->id ?>">
    <div class="panel panel-default">
        <div class="panel-body">
            <p class="comment-content">
                <?php if ($item->comment->isActive()): ?>
                    <? $user = $item->comment->getUser() ?>

                <a class="author" href="<?= Html::encode(Url::to('#')) ?>"><?= Html::encode($user->username) ?></a>
                <span class="pull-right">
                    <?= Yii::$app->formatter->asRelativeTime($item->comment->created_at) ?>
                </span>

                <?php if ($user->avatar): ?>
                    <?= Html::img($user->getThumbFileUrl('avatar', 'thumb'), ['class' => 'img-circle img-card']) ?>
                <?php else: ?>
                    <i class="fa fa-user-circle-o img-card"></i>
                <?php endif; ?>

                <?php if ($item->comment->isAuthor()): ?>
                    <span class="badge badge-pill pill-primary">Author</span>
                <?php endif; ?>

                   <p class="reply"><?= Yii::$app->formatter->asNtext($item->comment->text) ?>
                <?php else: ?>
                    <i>Deleted</i>
                <?php endif; ?>
            </p>
            <div>

                <div class="pull-right">
                    <span class="comment-reply"><i class="fa fa-reply"></i> Reply</span>
                </div>
            </div>
        </div>
    </div>
    <div class="margin">
        <div class="reply-block"></div>
        <div class="comments">
            <?php foreach ($item->children as $children): ?>
                <?= $this->render('_comment', ['item' => $children]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
