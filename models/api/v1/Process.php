<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\models\api\v1;

use app\models\api\Error;
use app\models\api\UserAccess;
use app\models\api\UserRestaurant;
use app\models\Dish;
use app\models\Order;
use app\models\OrderData;
use yii\base\Model;

class Process extends Model {

    const FIELD_LOGIN = 'login';
    const FIELD_PASS = 'pass';
    const FIELD_SESSION = 'session';

    protected $_return = array(
        '_' => null,
        'result' => null,
    );

    protected $_data = null;

    protected $_userAccess = null;
    protected $_userRestaurant = null;

    /**
     * Сохранение параметров
     *
     * @param $data
     *
     * @return $this
     */
    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setResult($key, $value) {
        $this->_return['result'][$key] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getReturn() {
        return $this->_return;
    }

    /**
     * @return UserAccess
     */
    public function getUserAccess() {
        return $this->_userAccess;
    }

    /**
     * @return UserRestaurant
     */
    public function getUserRestaurant() {
        return $this->_userRestaurant;
    }

    /**
     * Сохранение ошибки в вывод
     *
     * @param $code
     * @param $message
     */
    public function setError($code, $message) {
        $this->_return['error'] = array(
            'code' => $code,
            'message' => $message,
        );
    }

    /**
     * Проверка наличия ошибок
     *
     * @return bool
     */
    public function hasError() {
        return isset($this->_return['error']);
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return null
     */
    public function getData($key, $default = null) {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * Проверка наличия обязательных полей
     *
     * @param $action
     */
    public function checkRequired($action) {

        //Список обязательных полей для каждого метода
        switch($action) {
            case 'auth':
                $required_params = array(self::FIELD_LOGIN, self::FIELD_PASS);
                break;
            case 'orders':
                $required_params = array(self::FIELD_SESSION);
                break;
            default:
                $required_params = array();
                $this->setError(Error::ERR_METHOD, 'Unknown method: ' . $action);
        }

        //Проверяем наличие обязательных полей
        foreach($required_params as $_name) {
            if(!$this->getData($_name)) {
                $this->setError(Error::ERR_MISSING_REQUIRED_PARAM, 'Required param \''.$_name.'\' is missing');
                break;
            }
        }
    }

    /**
     * Загрузка данных пользователя по сессии
     *
     * @param $session_id
     */
    public function loadUser($session_id) {

        $this->_userAccess = UserAccess::findOne(['session_id' => $session_id]);

        //Если ключ доступа не найден
        if(!$this->getUserAccess()) {
            $this->setError(Error::ERR_SESSION, 'Unknown session');

            //Проверяем время с последнего доступа
        } elseif(!$this->getUserAccess()->checkSessionTime()) {
            $this->setError(Error::ERR_SESSION_EXPIRE, 'Session is expire.');
        }
    }

    /**
     * Получение новых заказов в ресторане
     */
    public function getNewOrders() {

        //Поиск необходимого ресторана
        $this->_userRestaurant = UserRestaurant::findOne(['user_id' => $this->getUserAccess()->user_id]);

        //Если пользователю не присвоен ресторан
        if(!$this->getUserRestaurant()) {
            $this->setError(Error::ERR_RESTAURANT_MISSING, 'Restaurant data is missing.');

            //Проверяем статус ресторана
            //TODO возможно это надо убрать
        } elseif(!$this->getUserRestaurant()->restaurant->status) {
            $this->setError(Error::ERR_RESTAURANT_MISSING, 'Restaurant data is missing.');
        }

        //Если ошибок нет
        if(!$this->hasError()) {
            //TODO вернуть список заказов
            $orders = Order::find()->where([
                'status' => Order::STATUS_NEW,
                'restaurant_id' => $this->getUserRestaurant()->restaurant_id
            ])->with('dishes')->all();

            //Если новые заказы есть
            $return = array();
            if($orders) {
                /** @var Order $_order */
                foreach($orders as $_order) {

                    $address = 'ул.' . $_order->street . ', д.' . $_order->house .
                        ($_order->apartment ? ', кв.'.$_order->apartment : '');

                    $orderList = array();
                    /** @var OrderData $_data */
                    foreach($_order->orderDatas as $_data) {
                        $orderList[] = [
                            'dish_id' => $_data->dish_id,
                            'dish_name' => $_data->dish->name,
                            'amount' => $_data->amount,
                        ];
                    }
                    $return[] = [
                        'order_id' => $_order->id,
                        'status' => $_order->status,
                        'created' => $_order->created,
                        'restaurant_id' => $_order->restaurant_id,
                        'total_cost' => $_order->total_cost,
                        'user_name' => $_order->username,
                        'user_phone' => $_order->phone,
                        'delivery_address' => $address,
                        'comment' => $_order->comment,
                        'order' => $orderList,
                    ];
                }

                $this->setResult('orderList', $return);
            }
        }
    }
}