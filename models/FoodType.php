<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food_type".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property integer $image_id
 *
 * @property File $image
 * @property Restaurant[] $restaurants
 * @property Dish[] $dishes
 */
class FoodType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'food_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'image_id'], 'integer'],
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
            'status' => 'Включено',
            'name' => 'Название',
            'image_id' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(File::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurants() {
        return $this->hasMany(Restaurant::className(), ['id' => 'restaurant_id'])->viaTable('restaurant_type', ['food_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishes() {
        return $this->hasMany(Dish::className(), ['id' => 'food_type_id']);
    }

}
