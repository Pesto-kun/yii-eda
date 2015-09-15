<?php

namespace app\controllers\admin;

use app\models\FoodType;
use app\models\Image;
use app\models\RestaurantType;
use Yii;
use app\models\Restaurant;
use yii\data\ActiveDataProvider;
use app\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RestaurantController implements the CRUD actions for Restaurant model.
 */
class RestaurantController extends AdminController
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
     * Lists all Restaurant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Restaurant::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

//    /**
//     * Displays a single Restaurant model.
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
     * Creates a new Restaurant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Restaurant();
        $image = new Image();

        if(Yii::$app->request->isPost){
            $image->uploadFile($image, 'file');

            if ($image->isFileUploaded() && $image->validate() && $image->saveFile('restaurant')) {
                $model->image_id = $image->id;
            }
        }

        //TODO тут надо добавить транзакций
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach($_POST['Restaurant']['foodTypes'] as $_foodType) {
                $restaurantType = new RestaurantType();
                $restaurantType->food_type_id = $_foodType;
                $model->link('restaurantTypes', $restaurantType);
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Updates an existing Restaurant model.
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

            //TODO удалять старый файл при обновлении
            if ($image->isFileUploaded() && $image->validate() && $image->saveFile('restaurant')) {
                $model->image_id = $image->id;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->unlinkAll('restaurantTypes');

            foreach($_POST['Restaurant']['foodTypes'] as $_foodType) {
                $restaurantType = new RestaurantType();
                $restaurantType->food_type_id = $_foodType;
                $model->link('restaurantTypes', $restaurantType);
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'image' => $image,
            ]);
        }
    }

    /**
     * Deletes an existing Restaurant model.
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
     * Finds the Restaurant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Restaurant::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
