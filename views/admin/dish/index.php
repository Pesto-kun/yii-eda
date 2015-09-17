<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блюда';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dish-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить блюдо', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'restaurant.name',
                'label' => 'Заведение'
            ],
            [
                'attribute' => 'foodType.name',
                'label' => 'Вид еды'
            ],
            'name',
            'weight',
            'price',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => Yii::$app->user->can('delete') ? '{update} {delete}' : '{update}',
            ],
        ],
    ]); ?>

</div>
