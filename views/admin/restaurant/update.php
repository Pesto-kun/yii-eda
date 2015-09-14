<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurant */
/* @var $image app\models\Image */

$this->title = 'Редактирование ресторана: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рестораны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="restaurant-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
    ]) ?>

</div>
