<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\models;

use Yii;
use yii\web\Cookie;

class Visitor extends \yii\base\Model {

    const COOKIE_VISITOR = 'visitor_city';

    protected $_city = null;
    protected $_defaultCity = 1; //Симферополь

    public function init() {
        parent::init();

        $cookies = Yii::$app->request->cookies;

        //Получаем данные корзины из куков
        if(isset($cookies[self::COOKIE_VISITOR])) {
            $this->_city = $cookies->getValue(self::COOKIE_VISITOR);
        } else {
            $this->_city = $this->_defaultCity;
        }
    }

    /**
     * Сохранение города
     *
     * @param $city
     *
     * @return $this
     */
    public function setCity($city) {

        $this->_city = $city;

        Yii::$app->response->cookies->add(new Cookie([
            'name' => self::COOKIE_VISITOR,
            'value' => $city,
        ]));

        return $this;
    }

    /**
     * Получение id города
     *
     * @return null
     */
    public function getCity() {
        return $this->_city;
    }
}