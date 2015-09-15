<?php

namespace app\controllers\ajax;

use Yii;
use Exception;
use app\models\Cart;
use yii\web\Response;

class CartController extends \yii\web\Controller
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_UNKNOWN = 'unknown';

    public function actionAdd()
    {
        $return = array(
            'status' => self::STATUS_UNKNOWN,
            'message' => '',
        );

        try {

            $data = Yii::$app->request->post();

            if(!isset($data['id'])) {
                throw new Exception('Не указан ID блюда');
            }

            //Загружаем корзину
            $cart = new Cart();

            //Добавляем блюдо
            $cart->addItem($data['id'], 1);

            //Получаем количество данного блюда
            $return['amount'] = $cart->getAmountOfSingleDish($data['id']);

            $return['status'] = self::STATUS_SUCCESS;

        } catch(Exception $e) {
            $return['status'] = self::STATUS_ERROR;
            $return['message'] = $e->getMessage();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionReduce()
    {
        $return = array(
            'status' => self::STATUS_UNKNOWN,
            'message' => '',
        );

        try {

            $data = Yii::$app->request->post();

            if(!isset($data['id'])) {
                throw new Exception('Не указан ID блюда');
            }

            //Загружаем корзину
            $cart = new Cart();

            //Добавляем блюдо
            $cart->reduceItem($data['id'], 1);

            //Получаем количество данного блюда
            $return['amount'] = $cart->getAmountOfSingleDish($data['id']);

            $return['status'] = self::STATUS_SUCCESS;

        } catch(Exception $e) {
            $return['status'] = self::STATUS_ERROR;
            $return['message'] = $e->getMessage();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

}
