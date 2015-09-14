<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurants array */

//use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\helpers\Html;

$this->title = 'My Yii Application';
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
                        'url' => ['index', 'id' => $_item->id],
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
                <?php foreach($restaurants as $_restaurant): ?>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= $_restaurant->name ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
