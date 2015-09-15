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

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'restaurant_id')->dropDownList($restaurants, ['prompt' => '- Не выбрано -'])?>

    <?= $form->field($model, 'food_type_id')->dropDownList($foodTypes, ['prompt' => '- Не выбрано -'])?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'weight')->textInput()->hint(Yii::t('app', 'gram')) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true])->hint(Yii::t('app', 'rub.'))  ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
