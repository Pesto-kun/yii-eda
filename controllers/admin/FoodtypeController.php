<?php

namespace app\controllers\admin;

use Yii;
use app\models\FoodType;
use app\models\Image;
use yii\data\ActiveDataProvider;
use app\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FoodtypeController implements the CRUD actions for FoodType model.
 */
class FoodtypeController extends AdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all FoodType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => FoodType::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single FoodType model.
//     * @param integer $id
//     * @return mixed
//     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new FoodType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FoodType();
        $image = new Image();

        if(Yii::$app->request->isPost){
            $image->uploadFile($image, 'file');

            if ($image->isFileUploaded() && $image->validate() && $image->saveFile('food_type')) {
                $model->image_id = $image->id;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Updates an existing FoodType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->image) {
            $image = $model->image;
        } else {
            $image = new Image();
        }

        if(Yii::$app->request->isPost){
            $image->uploadFile($image, 'file');

            if ($image->isFileUploaded() && $image->validate() && $image->saveFile('food_type')) {
                $model->image_id = $image->id;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Deletes an existing FoodType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        if($model->image_id) {
            /** @var $image Image */
            $image = Image::findOne($model->image_id);
            $image->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the FoodType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FoodType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FoodType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
