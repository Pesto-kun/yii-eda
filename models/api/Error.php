<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\models\api;

class Error {

    const ERR_MISSING_REQUIRED_PARAM = 101;     //Не передан обязательный параметр
    const ERR_METHOD = 102;                     //Неизвестный метод
    const ERR_LOGIN = 103;                      //Неверный логин или пароль
    const ERR_SESSION = 104;                    //Неверный ключ сессии

    const ERR_UNKNOWN = 999;

}