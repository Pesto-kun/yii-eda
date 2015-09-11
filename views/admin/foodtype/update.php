<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FoodType */
/* @var $file app\models\File */

$this->title = 'Редактирование вида еды: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Виды еды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="food-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'file' => $file,
    ]) ?>

</div>
