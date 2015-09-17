<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin';

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        } elseif(Yii::$app->user->identity->group === 'admin' || Yii::$app->user->can($action->id)) {
            return true;
        } else {
            throw new ForbiddenHttpException('Access denied');
        }
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
