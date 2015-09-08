<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurant */
/* @var $form yii\widgets\ActiveForm */

$cities = ArrayHelper::map(app\models\City::find()->asArray()->all(), 'id', 'name');;
?>

<div class="restaurant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'city_id')->dropDownList($cities, ['prompt' => '- Выберите город -'])?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_id')->textInput() ?>

    <?= $form->field($model, 'rating')->dropDownList(array(
        1 => '1 звезда',
        2 => '2 звезды',
        3 => '3 звезды',
        4 => '4 звезды',
        5 => '5 звезд',
    ), ['prompt' => '- Рейтинг -']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
