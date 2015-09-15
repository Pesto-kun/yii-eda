<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurant \app\models\Restaurant */
/* @var $_dish \app\models\Dish */

use yii\widgets\Menu;
use yii\helpers\Html;

$this->title = $restaurant->name;
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 sidebar">
                <h3>Выбор заведения</h3>

                <?php
                $items = array();
                foreach($menu as $_item) {
                    $img =  is_object($_item->image) ?
                        Html::img(DIRECTORY_SEPARATOR . $_item->image->filepath, ['style' => ['width' => '32px', 'height' => '32px']]) : '';
                    $items[] = [
                        'label' => $img . $_item->name,
                        'url' => ['index', 'id' => $restaurant->id, 'type' => $_item->id],
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
            <div class="col-lg-9">
                <?php foreach($restaurant->dishes as $_dish): ?>
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
            </div>
        </div>

    </div>
</div>
