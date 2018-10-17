<?php
namespace backend\controllers\store;

use application\forms\Store\LabelForm;
use application\services\Store\LabelService;
use Yii;
use application\models\Store\Label;
use backend\forms\Store\LabelSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class LabelController
 * @package backend\controllers\store
 */
class LabelController extends Controller
{
    private $labelService;

    /**
     * BrandController constructor.
     * @param string $id
     * @param Module $module
     * @param LabelService $labelService
     * @param array $config
     */
    public function __construct(string $id, Module $module, LabelService $labelService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->labelService = $labelService;
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
        $searchModel = new LabelSearch();
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
            'label' => $this->findModel($id),
        ]);
    }
    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new LabelForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $brand = $this->labelService->create($form);
                return $this->redirect(['view', 'id' => $brand->id]);
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
        $label = $this->findModel($id);
        $form = new LabelForm($label);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->labelService->edit($label->id, $form);
                return $this->redirect(['view', 'id' => $label->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'label' => $label,
        ]);
    }
    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->labelService->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Label the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Label
    {
        if (($model = Label::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}