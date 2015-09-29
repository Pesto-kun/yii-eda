<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurants \app\models\Restaurant[] */

//use yii\bootstrap\Nav;
use kartik\rating\StarRating;
use yii\widgets\Menu;
use yii\helpers\Html;
use app\models\Delivery;

/** @var \yii\web\Controller $controller */
$controller = $this->context;
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
                /** @var \app\models\FoodType $_item */
                foreach($menu as $_item) {
                    $img =  is_object($_item->image) ?
                        Html::img(DIRECTORY_SEPARATOR . $_item->image->filepath, ['style' => ['width' => '32px', 'height' => '32px']]) : '';
                    $items[] = [
                        'label' => $img . $_item->name,
                        'url' => ['index', 'food' => $_item->system_name],
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
            <div class="col-md-9">
                <?php if($restaurants): ?>
                    <?php foreach($restaurants as $_restaurant): ?>
                        <div class="panel panel-default pull-left" id="restaurant-<?= $_restaurant->id ?>">
                            <div class="panel-body">
                                <div>
                                    <?= Html::a($_restaurant->name, ['restaurant/index', 'name' => $_restaurant->system_name])?>
                                    <div class="pull-right">
                                        <div class="rating-container">
                                            <?php
                                            for($i = 0; $i < $_restaurant->rating; $i++) echo '<span class="glyphicon glyphicon-star"></span>';
                                            for($i = $_restaurant->rating; $i < 5; $i++) echo '<span class="glyphicon glyphicon-star-empty"></span>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $img =  is_object($_restaurant->image) ?
                                    Html::img(DIRECTORY_SEPARATOR . $_restaurant->image->filepath,
                                        ['style' => ['width' => '200px', 'height' => '250px']]) : '';
                                ?>
                                <div class="text-center"><?= $img ?></div>
                                <?php if($discount = $_restaurant->getMaxDiscount()): ?>
                                    <div class="bg-danger">Скидки до <?= $discount?>%</div>
                                <?php endif; ?>
                                <div><?= $_restaurant->work_time ?></div>
                                <div>Доставка - <?= $_restaurant->delivery_price ?> руб.</div>
                                <div>Бесплатная доставка - <?= $_restaurant->delivery_free ?> руб.</div>
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
