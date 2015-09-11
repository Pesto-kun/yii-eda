<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Города';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить город', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'status',
                'value' => function ($data) { return $data->status === 1 ? 'Включено' : 'Отключено'; },
                'label' => 'Статус'
            ],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
	            'headerOptions' => ['width' => '80'],
	            'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
