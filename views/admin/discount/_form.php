<?php

/* @var $this yii\web\View */
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $model app\models\Discount */
/* @var $form kartik\widgets\ActiveForm */

$restaurants = ArrayHelper::map(\app\models\Restaurant::find()->where(['status' => 1])->all(), 'id', 'name');
$foodTypes = ArrayHelper::map(\app\models\FoodType::find()->where(['status' => 1])->all(), 'id', 'name');
?>

<div class="discount-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-sm-6">
        <?= $form->field($model, 'restaurant_id')->widget(Select2::className(), [
            'language' => 'ru',
            'data' => $restaurants,
            'options' => ['placeholder' => 'Выбирете заведение...'],
            'addon' => [
                'prepend' => [
                    'content' => Html::icon('home'),
                ],
            ]
        ]); ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'food_type_id')->widget(Select2::className(), [
            'language' => 'ru',
            'data' => $foodTypes,
            'options' => ['placeholder' => 'Выбирете категорию...'],
            'addon' => [
                'prepend' => [
                    'content' => Html::icon('cutlery'),
                ],
            ]
        ]); ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'discount', ['addon' => ['append' => ['content'=>'%']]])->textInput(['maxlength' => true])  ?>
    </div>

    <div class="col-sm-6">
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

    <div class="col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить изменения', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
