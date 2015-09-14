<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\models;

use yii\base\Model;

class Delivery extends Model {

    protected static $_deliveryTypes = [
        'standart' => 'Стандартная доставка',
        'free' => 'Бесплатная доставка',
    ];

    static public function getOptions() {
        return self::$_deliveryTypes;
    }

    static public function getDeliveryTypeName($deliveryType) {
        return isset(self::$_deliveryTypes[$deliveryType]) ? self::$_deliveryTypes[$deliveryType] : null;
    }
}