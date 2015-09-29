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
                'format'=>'raw',
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->status ?
                        '<span class="label label-success">Активно</span>' :
                        '<span class="label label-danger">Неактивно</span>';
                },
                'label' => 'Статус'
            ],
            [
                'format'=>'raw',
                'attribute' => 'order_available',
                'value' => function ($data) {
                    return $data->order_available ?
                        '<span class="label label-success">Разрешено</span>' :
                        '<span class="label label-danger">Запрещено</span>';
                },
                'label' => 'Оформление заказов'
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
                'attribute' => 'user.username',
                'label' => 'Пользователь API'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '80'],
                'template' => Yii::$app->user->can('delete') ? '{update} {delete}' : '{update}',
            ],
        ],
    ]); ?>

</div>
