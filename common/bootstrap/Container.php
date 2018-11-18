<?php
namespace common\bootstrap;

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use src\services\FeedbackService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

/**
 * Class Container
 * @package common\bootstrap
 */
class Container implements BootstrapInterface
{
    /**
     * DI configuring
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(CKEditor::class, [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
        ]);

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(FeedbackService::class, [], [
            $app->params['adminEmail']
        ]);
    }
}
