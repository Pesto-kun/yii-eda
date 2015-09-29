<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "food_type".
 *
 * @property integer $id
 * @property integer $status
 * @property string $name
 * @property string $system_name
 * @property integer $image_id
 *
 * @property Image $image
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
            [['name', 'system_name'], 'required'],
            [['name', 'system_name'], 'string', 'max' => 255]
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
            'system_name' => 'Системное название',
            'image_id' => 'Изображение',
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
    public function getRestaurants() {
        return $this->hasMany(Restaurant::className(), ['id' => 'restaurant_id'])->with('image')->with('discounts')
            ->where(['status' => 1])->viaTable('restaurant_type', ['food_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDishes() {
        return $this->hasMany(Dish::className(), ['id' => 'food_type_id']);
    }

    public function setImage($image)
    {
        $this->populateRelation('image', $image);
    }

    public function loadUploadedImage()
    {
        $image = new Image();
        $image->uploadFile($image, 'file');
        if ($image->isFileUploaded() && $image->validate() && $image->saveFile('food_type')) {
            $this->image_id = $image->id;
        }
        $this->setImage($image);
    }

}
