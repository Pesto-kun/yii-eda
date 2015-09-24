<?php

namespace app\controllers\ajax;

use app\models\api\UserAccess;
use app\models\api\UserRestaurant;
use Yii;
use Exception;
use app\models\Cart;
use yii\base\UserException;
use yii\web\Response;

class CartController extends \yii\web\Controller
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_UNKNOWN = 'unknown';

    protected $_return = array(
        'status' => self::STATUS_UNKNOWN,
        'message' => '',
    );

    protected function setReturn($key, $value) {
        $this->_return[$key] = $value;
        return $this;
    }

    protected function getReturn() {
        return $this->_return;
    }

    public function actionAdd()
    {

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
            $this->setReturn('amount', $cart->getAmountOfSingleDish($data['id']));

            $this->setReturn('status', self::STATUS_SUCCESS);

        } catch(Exception $e) {
            $this->setReturn('status', self::STATUS_ERROR);
            $this->setReturn('message', $e->getMessage());
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getReturn();
    }

    public function actionReduce()
    {
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
            $this->setReturn('amount', $cart->getAmountOfSingleDish($data['id']));

            $this->setReturn('status', self::STATUS_SUCCESS);

        } catch(Exception $e) {
            $this->setReturn('status', self::STATUS_ERROR);
            $this->setReturn('message', $e->getMessage());
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getReturn();
    }

    /**
     * Проверка доступности заведения
     */
    public function actionAvailable() {

        //Данные корзины
        $cart = new Cart();

        try {

            //Проверяем возможность рестораном принимать заказы
            $cart->checkAvailableToOrder();

            //Проверка доступности заведения
            /** @var UserRestaurant $userRestaurant */
            $userRestaurant = UserRestaurant::findOne(['restaurant_id' => $cart->getRestaurantId()]);
            if(!$userRestaurant) {
                throw new UserException('В данный момент заведение недоступно для оформления заказа. Пожалуйста, попробуйте позже.');
            }

            /** @var UserAccess $userAccess */
            $userAccess = UserAccess::findOne(['user_id' => $userRestaurant->user_id]);
            if(!$userAccess) {
                throw new UserException('В данный момент заведение недоступно для оформления заказа. Пожалуйста, попробуйте позже.');
            }

            if($userAccess->isOnline()) {
                $this->setReturn('status', self::STATUS_SUCCESS);
            } else {
                throw new UserException('Заведение в оффлайне.');
            }

        } catch(UserException $e) {
            $this->setReturn('status', self::STATUS_ERROR);
            $this->setReturn('message', $e->getMessage());
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->getReturn();
    }


}
