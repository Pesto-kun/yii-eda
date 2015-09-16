<?php
/* @var $this yii\web\View */
/* @var $dishes app\models\Dish[] */
/* @var $cart app\models\Cart */

use nirvana\showloading\ShowLoadingAsset;
use yii\helpers\Html;

//Подключение стилей и скритов для прелоадера
ShowLoadingAsset::register($this);

//Скрипт для добавления\редактирвоания корзины
$this->registerJsFile('/js/cart.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = 'Корзина';
$total = 0;
?>

<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="body-content">
        <td class="row">
            <p class="pull-right"><?= Html::a('Очистить корзину', ['cart/clear'],
                    ['class' => 'btn btn-link']) ?></p>
            <table class="table">
                <?php foreach($dishes as $_dish): ?>
                    <tr id="dish-<?= $_dish->id ?>">
                        <td><?= $_dish->name ?></td>
                        <td><?= $_dish->weight ?> гр.</td>
                        <td>
                            <?= Html::a('-', null, ['onclick' => 'processCart("reduce",'.$_dish->id.')'])?>
                            <span class="in-cart"><?= $cart->getAmountOfSingleDish($_dish->id) ?></span>
                            <?= Html::a('+', null, ['onclick' => 'processCart("add",'.$_dish->id.')'])?>
                        </td>
                        <td><?= $_dish->price ?> руб.</td>
                    </tr>
                    <?php $total += ($_dish->price * $cart->getAmountOfSingleDish($_dish->id)); ?>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6">Итого: <?= $total ?> руб.</div>
            <div class="col-md-6"><span class="pull-right"><?= Html::a('Оформить заказ', ['cart/checkout'],
                        ['class' => 'btn btn-warning']) ?></span></div>
        </div>
    </div>
</div>
