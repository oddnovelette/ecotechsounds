<?php
namespace common\bootstrap;

use application\services\FeedbackService;
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

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(FeedbackService::class, [], [
            $app->params['adminEmail']
        ]);
    }
}
