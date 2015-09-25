<?php

namespace app\controllers\ajax;

use app\models\api\UserAccess;
use app\models\api\UserRestaurant;
use Yii;
use Exception;
use app\models\Cart;
use yii\base\UserException;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';
    const STATUS_UNKNOWN = 'unknown';

    protected $_return = array(
        'status' => self::STATUS_UNKNOWN,
        'message' => '',
    );

    protected function setReturn($key, $value) {
        $this->_return[$key] = $value;
        return $this;
    }

    protected function getReturn() {
        return $this->_return;
    }
}
