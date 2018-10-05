<?php
namespace frontend\controllers;

use Yii;
use yii\base\Module;
use yii\web\{BadRequestHttpException, Controller};
use yii\filters\{VerbFilter, AccessControl};
use application\services\{FeedbackService, PasswordResetService, SignupService, AuthService};
use application\forms\{PasswordResetRequestForm, ResetPasswordForm, SignupForm, ContactForm, LoginForm};

/**
 * Class SiteController
 * @package frontend\controllers
 */
class SiteController extends Controller
{
    private $passwordResetService, $feedbackService, $signupService, $authService;

    /**
     * Frontend SiteController constructor.
     * @param string $id
     * @param Module $module
     * @param AuthService $authService
     * @param SignupService $signupService
     * @param PasswordResetService $passwordResetService
     * @param FeedbackService $feedbackService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        AuthService $authService,
        SignupService $signupService,
        PasswordResetService $passwordResetService,
        FeedbackService $feedbackService,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authService = $authService;
        $this->signupService = $signupService;
        $this->passwordResetService = $passwordResetService;
        $this->feedbackService = $feedbackService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
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

    /**
     * Logs out the current user.
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     * @return mixed
     */
    public function actionContact()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->feedbackService->send($form);
                Yii::$app->session->setFlash('success', 'Thanks! We will respond to you as soon as possible.');
                return $this->goHome();
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'Error occured while sending your message..');
            }
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $form,
        ]);
    }

    /**
     * Displays about page.
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->signupService->signup($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    public function actionConfirm(string $token)
    {
        try {
            $this->signupService->confirm($token);
            Yii::$app->session->setFlash('success', 'Thanks, now you can log-in.');
            return $this->redirect(['login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->goHome();
        }
    }

    /**
     * Requests password reset.
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $form,
        ]);
    }

    /**
     * Resets password.
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException,\DomainException
     */
    public function actionResetPassword(string $token)
    {
        try {
            $this->passwordResetService->validateToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $form = new ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->passwordResetService->reset($token, $form);
                Yii::$app->session->setFlash('success', 'New password saved.');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->goHome();
        }
        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }
}
