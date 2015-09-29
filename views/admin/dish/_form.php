<?php
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $image app\models\Image */
/* @var $form kartik\widgets\ActiveForm */

$restaurants = ArrayHelper::map(app\models\Restaurant::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');
$foodTypes = ArrayHelper::map(app\models\FoodType::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');
?>

<div class="dish-form">

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
        <?= $form->field($model, 'price', ['addon' => ['append' => ['content'=>'рублей']]])->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-sm-4">
        <?= $form->field($model, 'discount', ['addon' => ['append' => ['content'=>'%']]])->textInput(['maxlength' => true])  ?>
    </div>

    <div class="col-sm-4">
        <?php if($model->discount_date) {$model->discount_date = Yii::$app->formatter->asDate($model->discount_date, 'php:d.m.Y');} ?>
        <?= $form->field($model, 'discount_date')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pickerButton' =>false,
            'options' => [
                'placeholder' => 'Выбрать дату'
            ],
            'pluginOptions' => [
                'todayHighlight' => true,
                'autoclose'=>true,
                'format' => 'dd.mm.yyyy',
            ]
        ]) ?>
    </div>


    <div class="col-sm-4">
        <?= $form->field($model, 'weight', ['addon' => ['append' => ['content'=>'грамм']]])->textInput() ?>
    </div>

    <div class="col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
