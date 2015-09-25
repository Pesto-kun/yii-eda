<?php

/* @var $this \yii\web\View */
/* @var $content string */
use app\assets\FrontendAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
//use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
//FrontendAsset::register($this);
$cities = ArrayHelper::map(app\models\City::find()->where(['status' => 1])->asArray()->all(), 'id', 'name');
$visitor = new \app\models\Visitor();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <div class="row">
            <p class="pull-left">Тут будут социальные кнопки</p>
            <p class="pull-right">Тут будет строка поиска</p>
        </div>
        <div class="well row">
            <div class="col-sm-4">
                Заказ еды в
                <?php foreach($cities as $_id => $_city) {
                    if($visitor->getCity() == $_id) {
                        print $_city;
                    } else {
                        print Html::a($_city, ['visitor/city', 'city_id' => $_id]);
                    }
                } ?>
            </div>
            <div class="col-sm-4"><?= Html::a('Логотип', ['site/index']) ?></div>
            <div class="col-sm-4">+7(978)999-99-99 <?= Html::a('Корзина', ['cart/index']) ?></div>
        </div>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"></p>

        <p class="pull-right">Batter World, <?= date('Y') ?> г.<br><?= Html::a('О сервисе', ['/site/about']) ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
