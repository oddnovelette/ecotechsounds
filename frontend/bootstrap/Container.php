<?php
namespace frontend\bootstrap;

use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/**
 * Class Container
 * @package frontend\bootstrap
 */
class Container implements BootstrapInterface
{
    public function bootstrap($app) : void
    {
        $container = \Yii::$container;

        $container->set(Breadcrumbs::class, function ($container, $params, $args) {
            return new Breadcrumbs(ArrayHelper::merge([
                'homeLink' => [
                    'label' => '<i class="fa fa-angle-double-left"></i>',
                    'encode' => false,
                    'url' => \Yii::$app->homeUrl,
                ],
            ], $args));
        });
    }
}
