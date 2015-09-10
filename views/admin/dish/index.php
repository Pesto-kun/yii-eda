<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dishes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Dish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
//            'restaurant_id',
            [
                'attribute' => 'restaurant.name',
                'label' => Yii::t('app', 'Restaurant')
            ],
            [
                'attribute' => 'foodType.name',
                'label' => Yii::t('app', 'Food type')
            ],
            'name',
            'image_id',
             'weight',
             'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
