<?php
namespace backend\controllers\store;

use application\forms\Store\Product\{PhotosForm, ProductForm};
use application\services\Store\ProductService;
use Yii;
use application\models\Store\Product;
use backend\forms\Store\ProductSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class ProductController
 * @package backend\controllers\Store
 */
class ProductController extends Controller
{
    private $productService;

    public function __construct($id, Module $module, ProductService $productService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->productService = $productService;
    }

    public function behaviors() : array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
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
        $product = $this->findModel($id);
        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->productService->addPhotos($product->id, $photosForm);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'product' => $product,
            'photosForm' => $photosForm,
        ]);
    }
    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ProductForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->productService->create($form);
                Yii::$app->session->setFlash('info', 'New product successfully created');
                return $this->redirect(['view', 'id' => $product->id]);
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
        $product = $this->findModel($id);
        $form = new ProductForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->productService->edit($product->id, $form);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->productService->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->productService->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }
    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->productService->movePhotoUp($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }
    /**
     * @param integer $id
     * @param $photo_id
     * @return mixed
     */
    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->productService->movePhotoDown($id, $photo_id);
        return $this->redirect(['view', 'id' => $id, '#' => 'photos']);
    }
    /**
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) : Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}