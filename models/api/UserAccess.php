<?php

namespace app\models\api;

use app\models\User;
use Exception;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "api_user_access".
 *
 * @property integer $user_id
 * @property string $last_access
 * @property string $session_id
 *
 * @property User $user
 */
class UserAccess extends \yii\db\ActiveRecord
{
    //количество секунд с последнего доступа пользователья через апи
    //в течении которых пользователь считается онлайн и оформление заказа возможно
    const ONLINE_TIMER = 100;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_user_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['last_access', 'session_id'], 'safe'],
            [['user_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'last_access' => 'Время последнего доступа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function isOnline() {
        return (time() < (date("U",strtotime($this->last_access)) + self::ONLINE_TIMER));
    }

    /**
     * Метод выдачи сессии пользователю для доступа по API
     *
     * @param $user User
     * @param $pass
     *
     * @return bool
     * @throws Exception
     */
    public function authorizeUser($user, $pass) {

        //Проверяем, что пользователю доступна авторизаця через API
        if($user->group !== 'api') {
            throw new Exception('Login or password incorrect', Error::ERR_LOGIN);
        }

        //Проверяем пароль
        if(!$user->validatePassword($pass)) {
            throw new Exception('Login or password incorrect', Error::ERR_LOGIN);
        }

        $this->user_id = $user->id;
        $this->last_access = new Expression('NOW()');
        $this->session_id = Yii::$app->getSecurity()->generateRandomString();

        //Сохраняем изменения
        $this->save();
    }
}
