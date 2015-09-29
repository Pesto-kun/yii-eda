<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurant \app\models\Restaurant */
/* @var $dishes \app\models\Dish[] */
/* @var $cart array */
use kartik\rating\StarRating;
use yii\bootstrap\Modal;
use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\Delivery;
use nirvana\showloading\ShowLoadingAsset;

//Подключение стилей и скритов для прелоадера
ShowLoadingAsset::register($this);

//Скрипт для добавления\редактирвоания корзины
$this->registerJsFile('/js/cart.js', ['depends' => 'yii\web\JqueryAsset']);

/** @var \yii\web\Controller $controller */
$controller = $this->context;
$this->title = $restaurant->name;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div>
                                <?= $restaurant->name ?>
                                <div class="pull-right">
                                    <?php
                                    for($i = 0; $i < $restaurant->rating; $i++) echo '<span class="glyphicon glyphicon-star"></span>';
                                    for($i = $restaurant->rating; $i < 5; $i++) echo '<span class="glyphicon glyphicon-star-empty"></span>';
                                    ?>
                                </div>
                            </div>
                            <?php
                            $img =  is_object($restaurant->image) ?
                                Html::img(DIRECTORY_SEPARATOR . $restaurant->image->filepath, ['style' => ['width' => '200px', 'height' => '250px']]) : '';
                            ?>
                            <div class="text-center"><?= $img ?></div>
                            <div>Акций не придумано</div>
                            <div><?= $restaurant->work_time ?></div>
                            <div>Доставка - <?= $restaurant->delivery_price ?> руб.</div>
                            <div>Бесплатная доставка - <?= $restaurant->delivery_free ?> руб.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3>Выбор заведения</h3>

                    <?php
                    $items = array(
                        array(
                            'label' => 'Все блюда',
                            'url' => ['index', 'name' => $restaurant->system_name],
                        )
                    );
                    /** @var \app\models\FoodType $_item */
                    foreach($menu as $_item) {
                        $img =  is_object($_item->image) ?
                            Html::img(DIRECTORY_SEPARATOR . $_item->image->filepath, ['style' => ['width' => '32px', 'height' => '32px']]) : '';
                        $items[] = [
                            'label' => $img . $_item->name,
                            'url' => ['index', 'name' => $restaurant->system_name, 'food' => $_item->system_name],
                            'active' => ($_item->system_name === $controller->actionParams['food'])
                        ];
                    }
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-pills nav-stacked'],
                        'items' => $items,
                        'encodeLabels' => false,
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-md-9">
                <?php if($dishes): ?>
                    <?php foreach($dishes as $_dish): ?>
                        <div class="panel panel-default pull-left" id="dish-<?= $_dish->id ?>">
                            <div class="panel-body">
                                <div><?= $_dish->name ?></div>
                                <?php
                                $img =  is_object($_dish->image) ?
                                    Html::img(DIRECTORY_SEPARATOR . $_dish->image->filepath, ['style' => ['width' => '200px', 'height' => '250px']]) : '';
                                ?>
                                <div class="text-center"><?= $img ?></div>
                                <div>
                                    <table class="table">
                                        <tr>
                                            <td>Вес:<br/><?= $_dish->weight ?> г.</td>
                                            <td>
                                                <?php if($_dish->discount): ?>
                                                    <s><?= $_dish->price ?></s> руб.<br>
                                                <?php endif; ?>
                                                <?= $_dish->getPrice() ?> руб.
                                            </td>
                                            <td>
                                                <?= Html::a('-', null, ['onclick' => 'processCart("reduce",'.$_dish->id.')'])?>
                                                <span class="in-cart"><?= isset($cart[$_dish->id]) ? $cart[$_dish->id] : 0 ?></span>
                                                <?= Html::a('+', null, ['onclick' => 'processCart("add",'.$_dish->id.')'])?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Блюд в данной категории не найдено</div>
                <?php endif; ?>
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
</div>
