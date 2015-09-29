<?php
use kartik\widgets\SwitchInput;
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

    <div class="col-sm-12">
        <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onColor' => 'success',
                'offColor' => 'danger',
                'onText' => 'Да',
                'offText' => 'Нет',
            ]
        ]) ?>
    </div>

    <div class="col-sm-8">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($model, 'system_name')->textInput(['maxlength' => true]) ?>
    </div>

    <?php
    $pluginOptions = [
        'showPreview' => true,
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'browseClass' => 'btn btn-success btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
        'browseLabel' =>  'Select icon'
    ];
    if($model->image_id) {
        $pluginOptions['initialPreview'] = [Html::img($image->getInitialPreview(), ['class'=>'file-preview-image'])];
        $pluginOptions['browseClass'] = 'btn btn-default btn-block';
    }
    ?>
    <div class="col-sm-12">
        <?= $form->field($image, 'file')->widget(FileInput::className(), ['pluginOptions' => $pluginOptions])->label('Иконка') ?>
    </div>

    <div class="col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
