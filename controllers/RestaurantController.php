<?php

namespace app\controllers;

use app\models\Cart;
use app\models\FoodType;
use app\models\Restaurant;
use Yii;
use yii\web\Controller;

class RestaurantController extends Controller
{
    public function actionIndex($name, $food = null)
    {
        //Получаем список типов еды
        /** @var FoodType[] $foodTypes */
        $foodTypes = FoodType::find()->where(['status' => 1])->with('image')->indexBy('system_name')->all();

        //Получаем список всех заведений
        /** @var Restaurant $restaurant */
        $restaurant = Restaurant::findOne(['system_name' => $name, 'status' => 1]);

        //Если указан тип еды в заведении
        if(isset($foodTypes[$food])) {
            $dishes = $restaurant->getDishesByType($foodTypes[$food]->id)->all();
        } else {
            $dishes = $restaurant->dishes;
        }

        //Корзина
        $cart = new Cart();

        return $this->render('index', [
            'menu' => $foodTypes,
            'restaurant' => $restaurant,
            'dishes' => $dishes,
            'cart' => $cart->getCart(),
        ]);
    }

}
