<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FoodType */

$this->title = 'Create Food Type';
$this->params['breadcrumbs'][] = ['label' => 'Food Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="food-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
