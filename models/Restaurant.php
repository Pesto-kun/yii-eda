<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurant".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $city_id
 * @property string $name
 * @property integer $image_id
 * @property integer $rating
 *
 * @property Dish[] $dishes
 * @property Order[] $orders
 * @property City $city
 * @property RestaurantType[] $restaurantTypes
 */
class Restaurant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'city_id', 'image_id', 'rating'], 'integer'],
            [['name'], 'required'],
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
            'city_id' => 'City',
            'name' => 'Name',
            'image_id' => 'Image',
            'rating' => 'Rating',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishes()
    {
        return $this->hasMany(Dish::className(), ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['restaurant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurantTypes()
    {
        return $this->hasMany(RestaurantType::className(), ['restaurant_id' => 'id']);
    }

}
