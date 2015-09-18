<?php

namespace app\controllers\api;

use app\models\api\Error;
use Yii;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{

    const API_DEBUG = 1; //TODO поменять это в продакшене

    public $layout = 'api';
    public $defaultAction = 'error';

    protected $param = null;

    protected function getParam() {
       return $this->param;
    }

    public function createAction($id) {
        $return = parent::createAction($id);
        if(is_null($return)) {
            $this->redirect(['error']);
        }
        return $return;
    }

    public function actionError() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return array('error' => Error::ERR_UNKNOWN, 'message' => 'Error');
    }
}
