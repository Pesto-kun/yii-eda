<?php

namespace app\controllers\api;

use app\models\api\Error;
use app\models\api\UserAccess;
use app\models\api\v1\Process;
use app\models\User;
use Exception;
use Yii;
use yii\base\UserException;
use yii\web\Response;

class V1Controller extends ApiController
{

    const VER = '1.0.0';

    /**
     * @return Process
     */
    protected function getParam() {
        return parent::getParam();
    }

    public function beforeAction($action) {

        //Модель для работы с данными
        $model = new Process();
        $this->param = $model;

        //Получаем данные из поста
        $model->setData(Yii::$app->request->get()); //TODO поменять на post

        try {

            //Проверем наличие обязательных параметров
            $model->checkRequired($action->id);

            //Если это не авторизация
            if($action->id != 'auth' && !$model->hasError()) {

                //Проверяем ключ сессии
                $session_id = $model->getData($model::FIELD_SESSION);

                //Загружаем данные пользователя
                $model->loadUser($session_id);

                //Проверям доступ в зависимости от роли
                $model->checkActionAccess($action->id);

            }

        } catch(UserException $e) {
            $model->setError($e->getCode(), $e->getMessage());
        } catch(Exception $e) {
            $model->setError($e->getCode(), $e->getMessage());
        }

        return parent::beforeAction($action);
    }

    /**
     * Авторизация
     *
     * @return array
     */
    public function actionAuth()
    {

        //Модель для работы с данными
        $model = $this->getParam();

        //Проверяем наличие ошибок
        if(!$model->hasError()) {

            try {

                //Загружаем модель пользователя
                /** @var User $user */
                $user = User::findByUsername($model->getData($model::FIELD_LOGIN));

                //Проверяем наличие пользователя
                if(!$user) {
                    throw new Exception('Login or password incorrect', Error::ERR_LOGIN);
                }

                //Модель доступа
                /** @var UserAccess $userAccess */
                $userAccess = UserAccess::findOne($user->id);
                if(is_null($userAccess)) {
                    $userAccess = new UserAccess();
                }
                $userAccess->authorizeUser($user, $model->getData($model::FIELD_PASS));
                $model->setResult($model::FIELD_SESSION, $userAccess->session_id);

            } catch(UserException $e) {
                $model->setError($e->getCode(), $e->getMessage());
            } catch(Exception $e) {
                $model->setError($e->getCode(), $e->getMessage());
            }

        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->getReturn();
    }

    /**
     * Получение списка заказов
     *
     * @return array
     */
    public function actionOrders() {

        //Модель для работы с данными
        $model = $this->getParam();

        //Проверяем наличие ошибок
        if(!$model->hasError()) {

            try {

                //Получение списка новых заказов
                $model->getNewOrders();

            } catch(UserException $e) {
                $model->setError($e->getCode(), $e->getMessage());
            } catch(Exception $e) {
                $model->setError($e->getCode(), $e->getMessage());
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->getReturn();

    }

    /**
     * Принятие заказа
     *
     * @return array
     */
    public function actionOrderAccept() {

        //Модель для работы с данными
        $model = $this->getParam();

        //Проверяем наличие ошибок
        if(!$model->hasError()) {

            try {

                //Изменение статуса заказа
                $model->changeOrderStatus();

            } catch(UserException $e) {
                $model->setError($e->getCode(), $e->getMessage());
            } catch(Exception $e) {
                $model->setError($e->getCode(), $e->getMessage());
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->getReturn();

    }

    /**
     * Получение списка заявок на доставку
     *
     * @return array
     */
    public function actionDeliveryList() {

        //Модель для работы с данными
        $model = $this->getParam();

        //Проверяем наличие ошибок
        if(!$model->hasError()) {

            try {

                //Получаем список заявок на доставку
                $model->getDeliveryList();

            } catch(UserException $e) {
                $model->setError($e->getCode(), $e->getMessage());
            } catch(Exception $e) {
                $model->setError($e->getCode(), $e->getMessage());
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return $model->getReturn();

    }

}
