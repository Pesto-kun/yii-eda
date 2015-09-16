<?php

namespace app\models;

use Yii;

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
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_CANCEL = 'cancel';
    const STATUS_PROCESSED = 'process';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'delivery_method', 'payment_method', 'phone', 'username', 'street', 'house'], 'required'],
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

}
