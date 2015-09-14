<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FoodType */
/* @var $image app\models\Image */

$this->title = 'Редактирование вида еды: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Виды еды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="food-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
    ]) ?>

</div>
