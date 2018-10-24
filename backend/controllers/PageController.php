<?php
namespace backend\controllers;

use application\forms\PageForm;
use application\models\Page;
use application\services\PageService;
use backend\forms\PageSearch;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class CategoryController
 * @package backend\controllers\blog
 */
class PageController extends Controller
{
    private $pageService;

    /**
     * PageController constructor.
     * @param string $id
     * @param Module $module
     * @param PageService $pageService
     * @param array $config
     */
    public function __construct(string $id, Module $module, PageService $pageService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->pageService = $pageService;
    }

    public function behaviors() : array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PageSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'page' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new PageForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $category = $this->pageService->create($form);
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $page = $this->findModel($id);
        $form = new PageForm($page);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->pageService->edit($page->id, $form);
                return $this->redirect(['view', 'id' => $page->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'page' => $page,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->pageService->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) : Page
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
