<?php
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $image app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$restaurants = ArrayHelper::map(app\models\Restaurant::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');
$foodTypes = ArrayHelper::map(app\models\FoodType::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');
?>

<div class="dish-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-sm-12">
        <?= $form->field($model, 'status')->checkbox() ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'restaurant_id')->dropDownList($restaurants, ['prompt' => '- Не выбрано -'])?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'food_type_id')->dropDownList($foodTypes, ['prompt' => '- Не выбрано -'])?>
    </div>

    <div class="col-sm-12">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

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
    <div class="col-sm-12">
        <?= $form->field($image, 'file')->widget(FileInput::className(), ['pluginOptions' => $pluginOptions])->label('Иконка') ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($model, 'weight')->textInput()->hint(Yii::t('app', 'gram')) ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true])->hint('рублей')  ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($model, 'discount')->textInput(['maxlength' => true])->hint('%')  ?>
    </div>

    <div class="col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
