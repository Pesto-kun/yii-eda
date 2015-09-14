<?php

namespace app\controllers;

use app\models\FoodType;
use app\models\Restaurant;
use Yii;
use yii\web\Controller;

class RestaurantController extends Controller
{
    public function actionIndex($id)
    {
        //Получаем список типов заведений
        $foodTypes = FoodType::find()->where(['status' => 1])->with('image')->all();
        $restaurant = Restaurant::findOne(['id' => $id, 'status' => 1]);
        return $this->render('index', [
            'menu' => $foodTypes,
            'restaurant' => $restaurant,
        ]);
    }

}
