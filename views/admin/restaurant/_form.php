<?php
use app\models\Delivery;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Restaurant */
/* @var $image app\models\Image */
/* @var $form yii\widgets\ActiveForm */

$cities = ArrayHelper::map(app\models\City::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');;
$foodTypes = ArrayHelper::map(app\models\FoodType::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');;
?>

<div class="restaurant-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <?= $form->field($model, 'city_id')->dropDownList($cities, ['prompt' => '- Выберите город -'])?>

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

    <?= $form->field($model, 'rating')->dropDownList(array(
        1 => '1 звезда',
        2 => '2 звезды',
        3 => '3 звезды',
        4 => '4 звезды',
        5 => '5 звезд',
    ), ['prompt' => '- Рейтинг -']) ?>

    <?= $form->field($model, 'foodTypes')->checkboxList($foodTypes)->label('Вид еды') ?>

    <?= $form->field($model, 'work_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_price') ?>

    <?= $form->field($model, 'delivery_type')->dropDownList(Delivery::getOptions(), ['prompt' => '- Вид доставки -'])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
