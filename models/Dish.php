<?php

namespace app\models;

use DateTime;
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
 * @property float $price
 * @property integer $discount
 * @property integer $discount_date
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
            [['status', 'restaurant_id', 'food_type_id', 'image_id', 'weight', 'discount'], 'integer'],
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['discount'], 'number', 'min' => 0, 'max' => 100],
            [['discount'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 255],
            [['discount_date'], 'validateDate'],
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
            'food_type_id' => 'Категория',
            'name' => 'Название',
            'weight' => 'Вес',
            'price' => 'Цена',
            'discount' => 'Скидка',
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

    public function beforeSave($insert) {
        if($this->discount_date) {
            $dateFrom = DateTime::createFromFormat('d.m.Y', $this->discount_date);
            $this->discount_date = $dateFrom->getTimestamp();
        }
        return parent::beforeSave($insert);
    }

    public function setImage($image)
    {
        $this->populateRelation('image', $image);
    }

    public function loadUploadedImage()
    {
        $image = new Image();
        $image->uploadFile($image, 'file');
        if ($image->isFileUploaded() && $image->validate() && $image->saveFile('dish')) {
            $this->image_id = $image->id;
        }
        $this->setImage($image);
    }

    /**
     * Получение скидки на блюдо
     *
     * @return int
     */
    public function getDiscount() {
        $discount = 0;

        //Если установлена персональная скидка на блюдо
        if($this->discount && time() < $this->discount_date) {
            $discount = $this->discount;
        //Если установлена скидка на раздел
        } elseif(isset($this->restaurant->discounts[$this->food_type_id])) {
            $discount = $this->restaurant->discounts[$this->food_type_id]->discount;
        }

        return $discount;
    }

    /**
     * Метод получения цены блюда после всяких обработок с ней
     *
     * @return float
     */
    public function getPrice() {

        $price = $this->price;

        //Если указана скидка
        if($this->getDiscount()) {
            $price = ceil(($price * (100 - $this->getDiscount()))/100);
        }

        return $price;
    }
}
