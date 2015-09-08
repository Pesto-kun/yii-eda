<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Restaurant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
//            'city_id',
//            'city.name',
            [
                'attribute' => 'city.name',
                'label' => Yii::t('app', 'City')
            ],
            'name',
            'image_id',
             'rating',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
