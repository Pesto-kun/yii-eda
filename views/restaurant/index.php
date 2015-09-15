<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurant \app\models\Restaurant */
/* @var $dishes \app\models\Dish[] */
/* @var $cart array */
use kartik\rating\StarRating;
use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\Delivery;
use nirvana\showloading\ShowLoadingAsset;

//Подключение стилей и скритов для прелоадера
ShowLoadingAsset::register($this);

$this->registerJsFile('/js/cart.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = $restaurant->name;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 sidebar">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6"><?= $restaurant->name ?></div>
                                <div class="col-lg-6 text-center">
                                    <?= StarRating::widget([
                                        'name' => 'rating',
                                        'value' => $restaurant->rating,
                                        'pluginOptions' => [
                                            'readonly' => true,
                                            'showClear' => false,
                                            'showCaption' => false,
                                            'size' => 'xs'
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <?php
                            $img =  is_object($restaurant->image) ?
                                Html::img(DIRECTORY_SEPARATOR . $restaurant->image->filepath, ['style' => ['width' => '200px', 'height' => '250px']]) : '';
                            ?>
                            <div class="row"><?= $img ?></div>
                            <div class="row">Акций не придумано</div>
                            <div class="row"><?= $restaurant->work_time ?></div>
                            <div class="row"><?= Delivery::getDeliveryTypeName($restaurant->delivery_type) ?> - <?= $restaurant->delivery_price ?> руб.</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h3>Выбор заведения</h3>

                    <?php
                    $items = array();
                    foreach($menu as $_item) {
                        $img =  is_object($_item->image) ?
                            Html::img(DIRECTORY_SEPARATOR . $_item->image->filepath, ['style' => ['width' => '32px', 'height' => '32px']]) : '';
                        $items[] = [
                            'label' => $img . $_item->name,
                            'url' => ['index', 'id' => $restaurant->id, 'food' => $_item->id],
                            //                        'active' => true, //TODO активный пункт меню
                        ];
                    }
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => $items,
                        'encodeLabels' => false,
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-lg-9">
                <?php if($dishes): ?>
                    <?php foreach($dishes as $_dish): ?>
                        <div class="panel panel-default" id="dish-<?= $_dish->id ?>">
                            <div class="panel-body">
                                <div class="row"><?= $_dish->name ?></div>
                                <?php
                                $img =  is_object($_dish->image) ?
                                    Html::img(DIRECTORY_SEPARATOR . $_dish->image->filepath, ['style' => ['width' => '200px', 'height' => '250px']]) : '';
                                ?>
                                <div class="row"><?= $img ?></div>
                                <div class="row">
                                    <div class="col-lg-3">Вес: <?= $_dish->weight ?> г.</div>
                                    <div class="col-lg-6"><?= $_dish->price ?> руб.</div>
                                    <div class="col-lg-3">
                                        <?= Html::a('+', null, ['onclick' => 'processCart("add",'.$_dish->id.')'])?>
                                        <span class="in-cart"><?= isset($cart[$_dish->id]) ? $cart[$_dish->id] : 0 ?></span>
                                        <?= Html::a('-', null, ['onclick' => 'processCart("reduce",'.$_dish->id.')'])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Блюд в данной категории не найдено</div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
