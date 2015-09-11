<?php

/* @var $this yii\web\View */
/* @var $menu array */
/* @var $restaurants array */

//use yii\bootstrap\Nav;
use yii\widgets\Menu;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3 sidebar">
                <h3>Выбор заведения</h3>

                <?php
                $items = array();
                foreach($menu as $_id => $_title) {
                    $items[] = [
                        'label' => $_title,
                        'url' => ['index', 'id' => $_id],
                        'active' => true,
                    ];
                }
                echo Menu::widget([
                    'options' => ['class' => 'nav nav-sidebar'],
                    'items' => $items,
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
