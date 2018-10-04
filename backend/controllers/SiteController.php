<?php
namespace backend\controllers;

use application\services\AuthService;
use Yii;
use yii\base\Module;
use yii\web\Controller;
use yii\filters\VerbFilter;
use application\forms\LoginForm;

/**
 * Class SiteController
 * @package backend\controllers
 */
class SiteController extends Controller
{
    private $authService;
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'main-login';

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->authService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('login', [
            'model' => $form,
        ]);

    }

    public function actionLogout() : string
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
