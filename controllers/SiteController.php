<?php

namespace app\controllers;

use app\models\Visitor;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FoodType;
use app\models\Restaurant;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex($food = null)
    {

        //Получение города
        $visitor = new Visitor();

        //Получаем список типов заведений
        $foodTypes = FoodType::find()->where(['status' => 1])->with('image')->all();

        //Если указан тип еды в заведении
        if($food) {
            /** @var FoodType $foodType */
            $foodType = FoodType::find()->where(['system_name' => $food])->one();
            $restaurants = $foodType->getRestaurants()->andWhere(['city_id' => $visitor->getCity()])->all();
        } else {
            //Получаем список всех заведений
            $restaurants = Restaurant::find()->where(['status' => 1, 'city_id' => $visitor->getCity()])->with('image')->with('discounts')->all();
        }

        return $this->render('index', [
            'menu' => $foodTypes,
            'restaurants' => $restaurants,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['admin/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
            return $this->redirect(['admin/index']);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
//            Yii::$app->session->setFlash('contactFormSubmitted');
//
//            return $this->refresh();
//        }
//        return $this->render('contact', [
//            'model' => $model,
//        ]);
//    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTest() {
        echo Yii::$app->security->generateRandomString();
    }
}
