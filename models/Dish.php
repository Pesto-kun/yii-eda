<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dish".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $restaurant_id
 * @property string $name
 * @property integer $image_id
 * @property integer $weight
 * @property string $price
 *
 * @property Restaurant $restaurant
 * @property OrderData[] $orderDatas
 */
class Dish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'restaurant_id', 'image_id', 'weight'], 'integer'],
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255]
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
            'restaurant_id' => 'Restaurant ID',
            'name' => 'Name',
            'image_id' => 'Image ID',
            'weight' => 'Weight',
            'price' => 'Price',
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
        return $this->hasMany(OrderData::className(), ['dish_id' => 'id']);
    }
}
