<?php

namespace app\models\api;

use Yii;
use app\models\Restaurant;
use app\models\User;

/**
 * This is the model class for table "api_user_restaurant".
 *
 * @property integer $user_id
 * @property integer $restaurant_id
 *
 * @property Restaurant $restaurant
 * @property User $user
 */
class UserRestaurant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_user_restaurant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'restaurant_id'], 'required'],
            [['user_id', 'restaurant_id'], 'integer'],
            [['user_id', 'restaurant_id'], 'unique'],
//            [['user_id', 'restaurant_id'], 'unique', 'targetAttribute' => ['user_id', 'restaurant_id'], 'message' => 'The combination of User ID and Restaurant ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'ID пользовтаеля',
            'restaurant_id' => 'ID ресторана',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
