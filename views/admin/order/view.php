<?php
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $_dish app\models\Dish */

$this->title = 'Заказ №' . $model->id . ' ('.$model->restaurant->name.')';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить данный заказ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'created',
            [
                'attribute' => 'restaurant.name',
                'label' => 'Заведение'
            ],
            'delivery_method',
            'delivery_time',
            'delivery_cost',
            'payment_method',
            'total_cost',
            'phone',
            'username',
            'street',
            'house',
            'apartment',
            'comment',
        ],
    ]) ?>

    <h2>Содержимое заказа</h2>
    <?php
    $dataProvider = new ActiveDataProvider([
        'query' => $model->getOrderDatas(),
        'pagination' => false,
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'dish.name',
                'label' => 'Блюдо',
            ],
            [
                'attribute' => 'dish.foodType.name',
                'label' => 'Тип',
            ],
            'dish.price',
            'amount',
        ],
    ]); ?>

</div>
