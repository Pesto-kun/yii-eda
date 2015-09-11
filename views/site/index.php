<?php

/* @var $this yii\web\View */
/* @var $menu array */

use yii\bootstrap\Nav;

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
                    ];
                }
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-sidebar'],
                    'items' => $items,
                ]);
                ?>

            </div>
            <div class="col-lg-9">
                <p>Тут будет список заведений</p>
            </div>
        </div>

    </div>
</div>
