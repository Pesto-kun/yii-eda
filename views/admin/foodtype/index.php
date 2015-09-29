<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Виды еды';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'format'=>'raw',
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->status ?
                        '<span class="label label-success">Активно</span>' :
                        '<span class="label label-danger">Неактивно</span>';
                },
                'label' => 'Статус'
            ],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => Yii::$app->user->can('delete') ? '{update} {delete}' : '{update}',
            ],
        ],
    ]); ?>

</div>
