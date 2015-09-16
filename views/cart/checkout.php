<?php
/* @var $this yii\web\View */
/* @var $dishes app\models\Dish[] */
/* @var $cart app\models\Cart */
/* @var $order app\models\Order */

//use nirvana\showloading\ShowLoadingAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

//Подключение стилей и скритов для прелоадера
//ShowLoadingAsset::register($this);

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
            <div class="col-md-7">
                <div class="col-sm-12">
                    <?= $form->field($order, 'delivery_method')->radioList([
                        'self' => 'Самовывоз',
                        'address' => 'Доставка по адерсу',
                        'door' => 'Доставка до двери',
                    ]) ?>
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
                <div class="col-sm-12">
                    <?= $form->field($order, 'payment_method')->radioList([
                        'offline' => 'Наложенный платеж',
                        'online' => 'Безналчиный расчет',
                    ])->label('Выберите способ оплаты') ?>
                </div>
            </div>
            <div class="col-md-5">
                <h4>Ваш заказ:</h4>
                <table class="table">
                    <?php foreach($dishes as $_dish): ?>
                        <tr>
                            <td><?= $_dish->name ?></td>
                            <td><?= $_dish->price ?> руб.</td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?= $form->field($order, 'comment')->textarea(['rows' => 5]) ?>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-sm-12">
                <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary', 'name' => 'checkout-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
