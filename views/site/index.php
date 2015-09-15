<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurants \app\models\Restaurant[] */

//use yii\bootstrap\Nav;
use kartik\rating\StarRating;
use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\Delivery;

$this->title = 'Batter World';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-3 sidebar">
                <h3>Выбор заведения</h3>

                <?php
                $items = array(
                    array(
                        'label' => 'Все заведения',
                        'url' => ['index'],
                    )
                );
                foreach($menu as $_item) {
                    $img =  is_object($_item->image) ?
                        Html::img(DIRECTORY_SEPARATOR . $_item->image->filepath, ['style' => ['width' => '32px', 'height' => '32px']]) : '';
                    $items[] = [
                        'label' => $img . $_item->name,
                        'url' => ['index', 'food' => $_item->id],
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
            <div class="col-md-9">
                <?php if($restaurants): ?>
                    <?php foreach($restaurants as $_restaurant): ?>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8"><?= Html::a($_restaurant->name, ['restaurant/index', 'id' => $_restaurant->id])?></div>
                                    <div class="col-md-4 text-center">
                                        <?= StarRating::widget([
                                            'name' => 'rating',
                                            'value' => $_restaurant->rating,
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
                                $img =  is_object($_restaurant->image) ?
                                    Html::img(DIRECTORY_SEPARATOR . $_restaurant->image->filepath, ['style' => ['width' => '200px', 'height' => '250px']]) : '';
                                ?>
                                <div class="row"><?= $img ?></div>
                                <div class="row">Акций не придумано</div>
                                <div class="row"><?= $_restaurant->work_time ?></div>
                                <div class="row"><?= Delivery::getDeliveryTypeName($_restaurant->delivery_type) ?> - <?= $_restaurant->delivery_price ?> руб.</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div>Заведений в данной категории не найдено</div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
