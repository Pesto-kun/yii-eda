<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\controllers;

use app\models\Visitor;
use Exception;
use Yii;
use yii\base\UserException;
use yii\web\Controller;

class VisitorController extends Controller {

    public function actionCity($city_id) {

        try {

            $model = new Visitor();
            $model->setCity($city_id);

        } catch(Exception $e) {
            //TODO
        }

        $this->redirect(['site/index']);
    }

}