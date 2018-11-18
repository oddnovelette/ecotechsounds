<?php
namespace backend\controllers;

use yii\web\Controller;

/**
 * Class FileController
 * @package backend\controllers
 */
class FileController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex() : string
    {
        return $this->render('index');
    }
}
