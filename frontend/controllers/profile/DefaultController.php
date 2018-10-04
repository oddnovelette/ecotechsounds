<?php
namespace frontend\controllers\profile;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class DefaultController
 * @package frontend\controllers\profile
 */
class DefaultController extends Controller
{
    public function behaviors() : array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}