<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Dish;
use app\models\Order;
use app\models\OrderData;
use Exception;
use Yii;

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

    public function actionClear() {
        $cart = new Cart();
        $cart->clearCart();
        $this->redirect(['index']);
    }

    /**
     * Страница оформления заказа
     *
     * @return string|\yii\web\Response
     */
    public function actionCheckout() {

        //Заказ
        $order = new Order();

        //Корзина
        $cart = new Cart();

        if ($order->load(Yii::$app->request->post())) {

            try {

                //Передаем в заказ корзину
                $order->setCart($cart);

                //Добавление необходимых параметров заказа
                $order->processCart();

                //Проверяем даныне
                if ($order->validate()) {

                    //Сохраняем заказ
                    $order->save();

                    //Очищаем корзину
                    $cart->clearCart();

                    //Переход на страницу уведомления
                    $this->redirect(['success']);
                }

            } catch(Exception $e) {
                $this->redirect(['error']);
            }

        }

        //Если корзина пуста
        if(!$cart->getCart()) {
            return $this->redirect(['index']);
        }

        return $this->render('checkout', [
            'order' => $order,
            'dishes' => Dish::findAll(array_keys($cart->getCart())),
            'cart' => $cart,
        ]);
    }

    public function actionSuccess() {
        return $this->render('success');
    }

    public function actionError() {
        return $this->render('error');
    }
}
