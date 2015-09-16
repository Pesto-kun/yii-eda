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
 * @property string $system_name
 * @property integer $image_id
 * @property integer $rating
 * @property string $work_time
 * @property float $delivery_price
 * @property string $delivery_type
 *
 * @property Image $image
 * @property Dish[] $dishes
 * @property Order[] $orders
 * @property City $city
 * @property RestaurantType[] $restaurantTypes
 * @property FoodType[] $foodTypes
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
            [['delivery_price'], 'number', 'numberPattern' => '/^\d+([\.\,]\d{1,2})?$/'],
            [['name', 'system_name'], 'required'],
            [['name', 'work_time', 'delivery_type', 'system_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Включено',
            'city_id' => 'Город',
            'name' => 'Название',
            'system_name' => 'Системное название',
            'image_id' => 'Изображение',
            'rating' => 'Рейтинг',
            'work_time' => 'Время работы',
            'delivery_price' => 'Стоимость доставки',
            'delivery_type' => 'Вид доставки',
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
    public function getDishes()
    {
        return $this->hasMany(Dish::className(), ['restaurant_id' => 'id'])->with('image')->where(['status' => 1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishesByType($foodTypeId)
    {
        return $this->hasMany(Dish::className(), ['restaurant_id' => 'id'])->with('image')->where(['status' => 1, 'food_type_id' => $foodTypeId]);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodTypes() {
        return $this->hasMany(FoodType::className(), ['id' => 'food_type_id'])->viaTable('restaurant_type', ['restaurant_id' => 'id']);
    }
}
