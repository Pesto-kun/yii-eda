<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurant \app\models\Restaurant */
/* @var $dishes \app\models\Dish[] */

use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\Delivery;

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
                                <div class="col-lg-8"><?= $restaurant->name ?></div>
                                <div class="col-lg-4 text-center">
                                    <div class="glyphicon-stars">
                                        <?php for($i = 1; $i <= $restaurant->rating; $i++): ?>
                                            <div class="glyphicon-star"></div>
                                        <?php endfor; ?>
                                        <?php for($i = $restaurant->rating; $i <= 5; $i++): ?>
                                            <div class="glyphicon-star-empty"></div>
                                        <?php endfor; ?>
                                    </div>
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
                        <div class="panel panel-default">
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
                                    <div class="col-lg-3">Add</div>
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
