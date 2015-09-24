<?php
/* @var $this yii\web\View */
/* @var $dishes app\models\Dish[] */
/* @var $restaurant app\models\Restaurant */
/* @var $cart app\models\Cart */
/* @var $order app\models\Order */

use nirvana\showloading\ShowLoadingAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;

//Подключение стилей и скритов для прелоадера
ShowLoadingAsset::register($this);

//Скрипт для добавления\редактирвоания корзины
$this->registerJsFile('/js/cart.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Оформление заказа';
$total = 0;
?>

<div class="checkout-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'id' => 'checkout-form',
            ]); ?>
            <div class="form-group" id="checkout-fields">
                <div class="col-md-7">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-group field-order-city">
                                <?= Html::label("Город", 'city', ['class' => 'control-label']) ?>
                                <?= Html::textInput("city", 'Симферополь', ['class' => 'form-control', 'readonly' => true]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($order, 'phone')->textInput(['placeholder' => '+7(___)___-__-__'])->label('Ваш телефон') ?>
                    </div>
                    <div class="col-sm-6">
                        <?= $form->field($order, 'username')->textInput()->label('Ваше имя') ?>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <?= $form->field($order, 'street')->textInput()->label('Адрес доставки') ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($order, 'house')->textInput(['placeholder' => 'Дом'])->label('') ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($order, 'apartment')->textInput(['placeholder' => 'Кв'])->label('') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4>Ваш заказ:</h4>
                    <table class="table">
                        <?php foreach($dishes as $_dish): ?>
                            <tr>
                                <td><?= $_dish->name ?></td>
                                <td>x <?= $cart->getAmountOfSingleDish($_dish->id) ?></td>
                                <td><?= $_dish->getPrice() * $cart->getAmountOfSingleDish($_dish->id) ?> руб.</td>
                            </tr>
                            <?php $total += $_dish->getPrice() * $cart->getAmountOfSingleDish($_dish->id) ?>
                        <?php endforeach; ?>
                        <tr><td colspan="2">Доставка</td>
                            <td>
                                <?= number_format(($total < $restaurant->delivery_free) ? $restaurant->delivery_price : 0); ?> руб.
                            </td>
                        </tr>
                        <tr><td colspan="2">Итого</td><td><?= $total ?> руб.</td></tr>
                    </table>
                    <?= $form->field($order, 'comment')->textarea(['rows' => 5]) ?>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="form-group col-sm-12">
                <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary',
                    'name' => 'checkout-button', 'id' => 'checkout-cart']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="row">
            <?php
            Modal::begin([
                'header' => 'Ошибка!',
                'id' => 'cartModal',
            ]);
            echo '...';
            Modal::end();
            ?>
        </div>
    </div>
</div>
