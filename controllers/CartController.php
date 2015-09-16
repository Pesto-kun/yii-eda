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

                    //Добавление блюд к заказу
                    /** @var Dish $_dish */
                    foreach($order->getTmpDishes() as $_dish) {
                        $orderData = new OrderData();
                        $orderData->dish_id = $_dish->id;
                        $orderData->amount = $order->getCartModel()->getAmountOfSingleDish($_dish->id);
                        $order->link('orderDatas', $orderData);
                    }

                    //Очищаем корзину
                    $cart->clearCart();
                }

            } catch(Exception $e) {
                //TODO
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
}
