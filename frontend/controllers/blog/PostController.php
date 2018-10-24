<?php
namespace frontend\controllers\blog;

use application\forms\Blog\CommentForm;
use application\models\Blog\{Category, Post, Tag};
use application\services\Blog\CommentService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    public function actionPost($slug)
    {
        if (!$post = Post::findOne(['slug' => $slug, 'status' => Post::STATUS_PUBLISHED])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $post->processViewsCounter();
        $user = Yii::$app->user->identity;
        return $this->render('post', [
            'post' => $post,
            'user' => $user,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionComment($id)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('warning', 'You must be logged in for comments');
            return $this->redirect(['/site/login']);
        }
        if (!$post = Post::findOne($id)) throw new \RuntimeException('Post not found.');

        $form = new CommentForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $comment = $this->commentService->create($post->id, Yii::$app->user->id, $form);
                return $this->redirect(['post', 'slug' => $post->slug, '#' => 'comment_' . $comment->id]);
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
}
