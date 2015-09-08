<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "restaurant_type".
 *
 * @property integer $food_type_id
 * @property integer $restaurant_id
 *
 * @property Restaurant $restaurant
 * @property FoodType $foodType
 */
class RestaurantType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'restaurant_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['food_type_id', 'restaurant_id'], 'integer'],
            [['food_type_id', 'restaurant_id'], 'unique', 'targetAttribute' => ['food_type_id', 'restaurant_id'], 'message' => 'The combination of Food Type ID and Restaurant ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'food_type_id' => 'Food Type ID',
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
    public function getFoodType()
    {
        return $this->hasOne(FoodType::className(), ['id' => 'food_type_id']);
    }
}
