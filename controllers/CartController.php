<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Dish;

class CartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //Корзина
        $cart = new Cart();

        if($cart->getCart()) {

            return $this->render('index', [
                'dishes' => Dish::findAll(array_keys($cart->getCart())),
                'cart' => $cart,
            ]);
        } else {
            return $this->render('empty');
        }
    }

}
