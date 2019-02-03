<?php
namespace backend\controllers;

use src\services\AuthService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;
use src\forms\LoginForm;
use yii\web\ForbiddenHttpException;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends Controller
{
    private $authService;

    /**
     * Backend SiteController constructor.
     * @param string $id
     * @param Module $module
     * @param AuthService $authService
     * @param array $config
     */
    public function __construct(string $id, Module $module, AuthService $authService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->authManager->checkAccess(Yii::$app->user->id, 'admin')) {
            return $this->actionLogin();
        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'main-login';

        $form = new LoginForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (ForbiddenHttpException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('login', [
            'model' => $form,
        ]);

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
