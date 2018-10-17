<?php
namespace backend\controllers\store;

use application\forms\Store\CategoryForm;
use application\services\store\CategoryService;
use Yii;
use application\models\Store\Category;
use backend\forms\Store\CategorySearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class CategoryController
 * @package backend\controllers\store
 */
class CategoryController extends Controller
{
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param int $id
     * @param Module $module
     * @param CategoryService $categoryService
     * @param array $config
     */
    public function __construct($id, Module $module, CategoryService $categoryService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->categoryService = $categoryService;
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

    public function actionIndex()
    {
        $searchModel = new CategorySearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        return $this->render('view', [
            'category' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new CategoryForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $category = $this->categoryService->create($form);
                Yii::$app->session->setFlash('info', 'Category created successfully');
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form
        ]);
    }

    public function actionUpdate($id)
    {
        $category = $this->findModel($id);
        $form = new CategoryForm($category);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->categoryService->edit($category->id, $form);
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    public function actionDelete(int $id)
    {
        try {
            $this->categoryService->remove($id);
            Yii::$app->session->setFlash('info', 'Category deleted successfully');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id) : Category
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
