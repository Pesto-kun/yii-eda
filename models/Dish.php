<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dish".
 *
 * @property integer $id
 * @property integer $status
 * @property integer $restaurant_id
 * @property integer $food_type_id
 * @property string $name
 * @property integer $image_id
 * @property integer $weight
 * @property string $price
 *
 * @property Image $image
 * @property Restaurant $restaurant
 * @property FoodType $foodType
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
            [['status', 'restaurant_id', 'food_type_id', 'image_id', 'weight'], 'integer'],
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
            'status' => 'Включено',
            'restaurant_id' => 'Заведение',
            'food_type_id' => 'Вид еды',
            'name' => 'Название',
            'weight' => 'Вес',
            'price' => 'Цена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
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
    public function getFoodType() {
        return $this->hasOne(FoodType::className(), ['id' => 'food_type_id']);
    }

//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getOrderDatas()
//    {
//        return $this->hasMany(OrderData::className(), ['dish_id' => 'id']);
//    }
}
