<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\models\api\v1;

use app\models\api\Error;
use yii\base\Model;

class Param extends Model {

    const FIELD_LOGIN = 'login';
    const FIELD_PASS = 'pass';
    const FIELD_SESSION = 'session';

    protected $_return = array(
        '_' => null,
        'result' => null,
    );

    protected $_data = null;

    /**
     * Сохранение параметров
     *
     * @param $data
     *
     * @return $this
     */
    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function setResult($key, $value) {
        $this->_return['result'][$key] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getReturn() {
        return $this->_return;
    }

    /**
     * Сохранение ошибки в вывод
     *
     * @param $code
     * @param $message
     */
    public function setError($code, $message) {
        $this->_return['error'] = array(
            'code' => $code,
            'message' => $message,
        );
    }

    /**
     * Проверка наличия ошибок
     *
     * @return bool
     */
    public function hasError() {
        return isset($this->_return['error']);
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return null
     */
    public function getData($key, $default = null) {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * Проверка наличия обязательных полей
     *
     * @param $action
     */
    public function checkRequired($action) {

        //Список обязательных полей для каждого метода
        switch($action) {
            case 'auth':
                $required_params = array(self::FIELD_LOGIN, self::FIELD_PASS);
                break;
            case 'orders':
                $required_params = array(self::FIELD_SESSION);
                break;
            default:
                $required_params = array();
                $this->setError(Error::ERR_METHOD, 'Unknown method: ' . $action);
        }

        //Проверяем наличие обязательных полей
        foreach($required_params as $_name) {
            if(!$this->getData($_name)) {
                $this->setError(Error::ERR_MISSING_REQUIRED_PARAM, 'Required param \''.$_name.'\' is missing');
                break;
            }
        }
    }

}