<?php

namespace app\models\api;

use app\models\User;
use Yii;
use yii\base\UserException;
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
    //Количество секунд с последнего доступа пользователья через апи
    //в течении которых пользователь считается онлайн и оформление заказа возможно
    const ONLINE_TIMER = 100;
    //Время жизни сессии
    //Считается время с последнего доступа пользователя
    const SESSION_LIFETIME = 43200; //12 часов

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

    /**
     * Метод проверки времени
     *
     * @param $sec
     *
     * @return bool
     */
    protected function _checkTime($sec) {
        return (time() < (date("U",strtotime($this->last_access)) + $sec));
    }

    /**
     * Проверка пользователя онлайн
     *
     * @return bool
     */
    public function isOnline() {
        return $this->_checkTime(self::ONLINE_TIMER);
    }

    /**
     * Проверка времени жизни сессии
     *
     * @return bool
     */
    public function checkSessionTime() {
        return $this->_checkTime(self::SESSION_LIFETIME);
    }

    /**
     * Метод выдачи сессии пользователю для доступа по API
     *
     * @param $user User
     * @param $pass
     *
     * @return bool
     * @throws UserException
     */
    public function authorizeUser($user, $pass) {

        //Проверяем, что пользователю доступна авторизаця через API
        //TODO переделать под ->can()
        if(!in_array($user->group, array('restaurant', 'delivery'))) {
            throw new UserException('Login or password incorrect', Error::ERR_LOGIN);
        }

        //Проверяем пароль
        if(!$user->validatePassword($pass)) {
            throw new UserException('Login or password incorrect', Error::ERR_LOGIN);
        }

        $this->user_id = $user->id;
        $this->last_access = new Expression('NOW()');
        $this->session_id = Yii::$app->getSecurity()->generateRandomString();

        //Сохраняем изменения
        $this->save();
    }
}
