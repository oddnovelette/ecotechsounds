<?php

namespace frontend\controllers;

use src\models\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class PageController
 * @package frontend\controllers
 */
class PageController extends Controller
{

    public function actionView(string $slug)
    {
        if (!$page = Page::find()->andWhere(['slug' => $slug])->one()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', [
            'page' => $page,
        ]);
    }
}
