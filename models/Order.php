<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $status
 * @property string $created
 * @property integer $restaurant_id
 *
 * @property Restaurant $restaurant
 * @property Dish[] $dishes
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
            [['status', 'restaurant_id'], 'required'],
            [['created'], 'safe'],
            [['restaurant_id'], 'integer'],
            [['status'], 'string', 'max' => 32]
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
            'restaurant_id' => 'Заведение',
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
