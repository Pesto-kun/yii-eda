<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Restaurant */
/* @var $image app\models\Image */

$this->title = 'Добавление заведения';
$this->params['breadcrumbs'][] = ['label' => 'Заведения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'image' => $image,
    ]) ?>

</div>
