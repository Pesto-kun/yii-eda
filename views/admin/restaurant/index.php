<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заведения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить заведение', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'city.name',
                'label' => 'Город'
            ],
            [
                'value' => function ($data) {
                    $arr = array();
                    foreach($data->foodTypes as $_foodType) {
                        $arr[] = $_foodType->name;
                    }
                    return implode(', ', $arr);
                },
                'label' => 'Тип заведения'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => Yii::$app->user->can('delete') ? '{update} {delete}' : '{update}',
            ],
        ],
    ]); ?>

</div>
