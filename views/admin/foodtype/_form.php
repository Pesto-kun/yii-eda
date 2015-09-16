<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\FoodType */
/* @var $image app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="food-type-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'system_name')->textInput(['maxlength' => true]) ?>

    <?php
        $pluginOptions = [
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false,
        ];
        if($model->image_id) {
            $pluginOptions['initialPreview'] = [Html::img($image->getInitialPreview(), ['class'=>'file-preview-image'])];
        }
    ?>
    <?= $form->field($image, 'file')->widget(FileInput::className(), ['pluginOptions' => $pluginOptions])->label('Иконка') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
