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
 * @property OrderData[] $orderDatas
 */
class Order extends \yii\db\ActiveRecord
{
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
            [['status'], 'required'],
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
            'id' => 'ID',
            'status' => 'Status',
            'created' => 'Created',
            'restaurant_id' => 'Restaurant ID',
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
}
