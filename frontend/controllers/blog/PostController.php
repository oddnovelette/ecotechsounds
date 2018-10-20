<?php
namespace frontend\controllers\blog;

use application\forms\Blog\CommentForm;
use application\models\Blog\{Category, Post, Tag};
use application\services\Blog\CommentService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class PostController
 * @package frontend\controllers\blog
 */
class PostController extends Controller
{
    public $layout = 'blog';

    private $commentService;

    public function __construct(string $id, Module $module, CommentService $commentService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->commentService = $commentService;
    }

    public function actionIndex()
    {
        $dataProvider = Post::getAll();
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @param $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCategory($slug)
    {
        if (!$category = Category::find()->andWhere(['slug' => $slug])->one()) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $dataProvider = Post::getAllByCategory($category);

        return $this->render('category', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $slug
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionTag($slug)
    {
        if (!$tag = Tag::findOne(['slug' => $slug])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $dataProvider = Post::getAllByTag($tag);

        return $this->render('tag', [
            'tag' => $tag,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPost($id)
    {
        if (!$post = Post::findOne(['id' => $id, 'status' => Post::STATUS_PUBLISHED])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $post->processViewsCounter();
        return $this->render('post', [
            'post' => $post,
        ]);
    }

    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', 'You must be logged in for this');
            return $this->redirect(['/site/login']);
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $post = $this->findModel($id);

        $user = Yii::$app->user->identity;
        //$post->submitLike($user);

        return [
            'success' => true,
        ];
    }

    public function actionDislike($id)
    {}

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionComment($id)
    {
        if (!$post = Post::findOne($id)) {
            throw new \RuntimeException('Post is not found.');
        }
        $form = new CommentForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $comment = $this->commentService->create($post->id, Yii::$app->user->id, $form);
                return $this->redirect(['post', 'id' => $post->id, '#' => 'comment_' . $comment->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('comment', [
            'post' => $post,
            'model' => $form,
        ]);
    }

    protected function findModel($id) : Post
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
