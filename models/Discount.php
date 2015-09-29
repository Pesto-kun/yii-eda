<?php

namespace app\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "discount".
 *
 * @property integer $id
 * @property integer $restaurant_id
 * @property integer $food_type_id
 * @property integer $discount
 * @property integer $discount_date
 *
 * @property FoodType $foodType
 * @property Restaurant $restaurant
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['restaurant_id', 'food_type_id', 'discount'], 'required'],
            [['restaurant_id', 'food_type_id', 'discount'], 'integer'],
            [['discount'], 'number', 'min' => 0, 'max' => 100],
            [['discount'], 'default', 'value' => 0],
            [['discount_date'], 'validateDate'],
            [['restaurant_id', 'food_type_id'], 'unique', 'targetAttribute' => ['restaurant_id', 'food_type_id'], 'message' => 'The combination of Restaurant ID and Food Type ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'restaurant_id' => 'ID ресторана',
            'food_type_id' => 'ID картегории',
            'discount' => 'Скидка',
            'discount_date' => 'Дата действия скидки',
        ];
    }

    public function validateDate($attribute, $params)
    {
        if(!preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $this->$attribute)) {
            $this->addError($attribute, 'Неверный формат даты. Дата дожна быть в формате DD-MM-YYYY.');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodType()
    {
        return $this->hasOne(FoodType::className(), ['id' => 'food_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRestaurant()
    {
        return $this->hasOne(Restaurant::className(), ['id' => 'restaurant_id']);
    }

    public function beforeSave($insert) {
        if($this->discount_date) {
            $dateFrom = DateTime::createFromFormat('d.m.Y', $this->discount_date);
            $this->discount_date = $dateFrom->getTimestamp();
        }
        return parent::beforeSave($insert);
    }

}
