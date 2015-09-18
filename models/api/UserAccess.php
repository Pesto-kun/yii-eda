<?php

namespace app\models\api;

use app\models\User;
use Yii;

/**
 * This is the model class for table "api_user_access".
 *
 * @property integer $user_id
 * @property string $last_access
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
            [['last_access'], 'safe'],
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
}
