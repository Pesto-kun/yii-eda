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
            [
                'attribute' => 'city.name',
                'label' => Yii::t('app', 'City')
            ],
            [
                'value' => function ($data) {
                    $arr = array();
                    foreach($data->foodTypes as $_foodType) {
                        $arr[] = $_foodType->name;
                    }
                    return implode(', ', $arr);
                },
                'label' => Yii::t('app', 'Food type')
            ],
            'name',
            'image_id',
            'rating',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>