<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FoodType */

$this->title = 'Добавление вида еды';
$this->params['breadcrumbs'][] = ['label' => 'Виды еды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
