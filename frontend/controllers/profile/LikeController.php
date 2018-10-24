<?php
namespace frontend\controllers\profile;

use application\models\Blog\Post;
use application\services\blog\PostLikeService;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class LikeController
 * @package frontend\controllers\profile
 */
class LikeController extends Controller
{
    public $layout = 'profile';

    private $service;

    public function __construct(string $id, Module $module, PostLikeService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;

    }
    public function behaviors() : array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = Post::getLikeList(\Yii::$app->user->id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', 'You must log in for likes');
            return $this->redirect(['/site/login']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $post_likes = $this->findModel($id)->likes_counter;
        try {
            $this->service->add(Yii::$app->user->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
        }
        return [
            'success' => true,
            'likes' => ++$post_likes,
        ];
    }

    public function actionDelete()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', 'You must log in for dislikes');
            return $this->redirect(['/site/login']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $post_likes = $this->findModel($id)->likes_counter;
        try {
            $this->service->remove(Yii::$app->user->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
        }
        return [
            'success' => true,
            'likes' => --$post_likes,
        ];
    }

    protected function findModel($id) : Post
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}