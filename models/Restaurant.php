<?php

namespace app\models;

use app\models\api\UserRestaurant;
use Yii;
use yii\web\UploadedFile;

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
 * @property User $user
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
            [['system_name'], 'unique', 'targetAttribute' => 'system_name'],
            [['name', 'work_time', 'delivery_type', 'system_name'], 'string', 'max' => 255],
            [['delivery_price'], 'default', 'value' => 0],
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

//    public function transactions()
//    {
//        return [
//            'default' => self::OP_INSERT | self::OP_UPDATE,
//        ];
//    }

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->viaTable('api_user_restaurant', ['restaurant_id' => 'id']);
    }

    public function setUser($user) {
        $this->populateRelation('user', $user);
    }

    public function setImage($image)
    {
        $this->populateRelation('image', $image);
    }

    public function setRestaurantTypes($restaurantTypes)
    {
        $this->populateRelation('restaurantTypes', $restaurantTypes);
    }

    public function setRestaurantTypesFromPost($value)
    {
        $restaurantTypes = [];

        if(is_array($value)) {
            foreach($value as $id) {
                $restaurantType = new RestaurantType();
                $restaurantType->food_type_id = $id;
                $restaurantTypes[] = $restaurantType;
            }
        }

        $this->setRestaurantTypes($restaurantTypes);
    }

    public function loadUploadedImage()
    {
        $image = new Image();
        $image->uploadFile($image, 'file');
        if ($image->isFileUploaded() && $image->validate() && $image->saveFile('restaurant')) {
            $this->image_id = $image->id;
        }
        $this->setImage($image);
    }

    public function afterSave($insert, $changedAttributes)
    {

        //Удаляем старые данные
        RestaurantType::deleteAll(['restaurant_id' => $this->id]);

        // Получаем все связанные модели, те что загружены или установлены
        $relatedRecords = $this->getRelatedRecords();
        if (isset($relatedRecords['restaurantTypes'])) {
            foreach ($relatedRecords['restaurantTypes'] as $restaurantType) {
                $this->link('restaurantTypes', $restaurantType);
            }
        }

    }

    public function setUserId($id) {
        //Смотрим, что данный id ещё не занят
        /** @var UserRestaurant $userRestaurant */
        $userRestaurant = UserRestaurant::findOne(['user_id' => $id]);
        if($userRestaurant && $userRestaurant->restaurant_id != $this->id) {
            $this->addError('user', 'Данный пользователь уже привязан к другому ресторану');
            return false;
        } else {
            if($userRestaurant) {
                $userRestaurant->restaurant_id = $this->id;
            } else {
                $userRestaurant = new UserRestaurant();
                $userRestaurant->user_id = $id;
                $userRestaurant->restaurant_id = $this->id;
                $userRestaurant->save();
            }
            return true;
        }
    }

}
