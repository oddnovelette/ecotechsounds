<?php
namespace backend\controllers;

use application\forms\User\UserCreateForm;
use application\forms\User\UserEditForm;
use application\services\UserService;
use Yii;
use application\models\User;
use backend\forms\UserSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class UserController
 * @package backend\controllers
 */
class UserController extends Controller
{
    private $userService;

    /**
     * UserController constructor.
     * @param string $id
     * @param Module $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct(string $id, Module $module, UserService $userService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
    }

    /**
     * @inheritdoc
     */
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Manually creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \DomainException
     */
    public function actionCreate()
    {
        $form = new UserCreateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->userService->create($form);
                Yii::$app->session->setFlash('success', 'User created successfully');
                return $this->redirect(['view', 'id' => $user->id]);
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws \DomainException
     */
    public function actionUpdate(int $id)
    {
        $user = $this->findModel($id);
        $form = new UserEditForm($user);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->userService->edit($user->id, $form);
                Yii::$app->session->setFlash('success', 'User updated successfully');
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        if (!$this->findModel($id)->delete()) {
            throw new \RuntimeException('User deleting error occured.');
        }
        Yii::$app->session->setFlash('success', 'User deleted successfully');
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
