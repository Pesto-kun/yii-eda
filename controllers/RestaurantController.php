<?php

namespace app\controllers;

use app\models\FoodType;
use app\models\Restaurant;
use Yii;
use yii\web\Controller;

class RestaurantController extends Controller
{
    public function actionIndex($id, $food = null)
    {
        //Получаем список типов еды
        $foodTypes = FoodType::find()->where(['status' => 1])->with('image')->all();

        //Получаем список всех заведений
        /** @var Restaurant $restaurant */
        $restaurant = Restaurant::find()->where(['status' => 1])->one();

        //Если указан тип еды в заведении
        if(is_numeric($food)) {
            $dishes = $restaurant->getDishesByType($food)->all();
        } else {
            $dishes = $restaurant->dishes;
        }

        return $this->render('index', [
            'menu' => $foodTypes,
            'restaurant' => $restaurant,
            'dishes' => $dishes,
        ]);
    }

}
