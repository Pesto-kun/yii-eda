<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Discount */

$this->title = 'Добавление скидки';
$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discount-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
