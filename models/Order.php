<?php

namespace app\models;

use Exception;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $status
 * @property string $created
 * @property string $updated
 * @property integer $restaurant_id
 * @property string $delivery_method
 * @property string $delivery_time
 * @property string $delivery_cost
 * @property string $payment_method
 * @property string $total_cost
 * @property string $phone
 * @property string $username
 * @property string $street
 * @property string $house
 * @property string $apartment
 * @property string $comment
 *
 * @property Restaurant $restaurant
 * @property OrderData[] $orderDatas
 * @property Dish[] $dishes
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_CANCEL = 'cancel';
    const STATUS_PROCESSED = 'process';

    /** @var \app\models\Cart */
    protected $_cart = null;

    //Временно сохранение загруженных блюд из корзины
    /** @var \app\models\Dish[] */
    protected $_dishes = array();

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    public function init() {
        parent::init();
        $this->status = self::STATUS_NEW;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_method', 'payment_method', 'phone', 'username', 'street', 'house'], 'required'],
            [['created', 'updated'], 'safe'],
            [['restaurant_id'], 'integer'],
            [['comment'], 'string'],
            [['status', 'delivery_method', 'delivery_cost', 'payment_method'], 'string', 'max' => 32],
            [['phone', 'username', 'street', 'house', 'apartment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Заказ №',
            'status' => 'Статус',
            'created' => 'Дата создания',
            'updated' => 'Обновлено',
            'restaurant_id' => 'ID заведения',
            'delivery_method' => 'Способ доставки',
            'delivery_time' => 'Время доставки',
            'delivery_cost' => 'Стоимость доставки',
            'payment_method' => 'Метод оплаты',
            'total_cost' => 'Итого к оплате',
            'phone' => 'Телефон',
            'username' => 'Имя',
            'street' => 'Улица',
            'house' => 'Дом',
            'apartment' => 'Квартира',
            'comment' => 'Комменатрий',
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => ['created', 'updated'],
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDatas()
    {
        return $this->hasMany(OrderData::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishes() {
        return $this->hasMany(Dish::className(), ['id' => 'dish_id'])->viaTable('order_data', ['order_id' => 'id']);
    }

    /**
     * @return array
     */
    static public function getStatusOptions() {
        return array(
            self::STATUS_NEW => 'Новый',
            self::STATUS_CANCEL => 'Отменен',
            self::STATUS_PROCESSED => 'Обрабатывается',
        );
    }

    /**
     * @param $cart \app\models\Cart
     *
     * @return $this
     */
    public function setCart($cart) {
        $this->_cart = $cart;
        return $this;
    }

    /**
     * @return \app\models\Cart
     */
    public function getCartModel() {
        return $this->_cart;
    }

    public function getTmpDishes() {
        return $this->_dishes;
    }
    public function setTmpDishes($dishes) {
        $this->_dishes = $dishes;
        return $this;
    }

    public function processCart() {

        $total = 0;

        //Загружаем блюда из заказа
        /** @var Dish[] $dishes */
        $dishes = Dish::find()->where(['in', 'id', array_keys($this->getCartModel()->getCart())])->andWhere(['status' => 1])->indexBy('id')->all();
        $this->setTmpDishes($dishes);

        //Проверяем корзину
        foreach($this->getCartModel()->getCart() as $id => $amount) {

            //Проверяем доступность блюда
            if(!isset($dishes[$id])) {
                throw new Exception('Блюдо из корзины не найдено');
            }

            //Проверяем поле количества
            if(!is_numeric($amount)) {
                throw new Exception('Для блюда id:'.$id.' передан неверный параметр количества');
            }

            //Проверяем ресторан
            if(!$this->getCartModel()->checkSameRestaurant($dishes[$id]->restaurant_id)) {
                throw new Exception('Невозможно оформить заказ с блюдами из разных заведений.');
            }

            $total += $amount * $dishes[$id]->price;
        }

        //ID ресторана
        $this->restaurant_id = $this->getCartModel()->getRestaurant();

        //TODO Стоимость доставки

        //TODO Стоимость оплаты

        //Стоимость заказа
        $this->total_cost = $total;

    }

}
