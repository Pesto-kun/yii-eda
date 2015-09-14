<?php
/**
 * @company BestArtDesign
 * @site http://bestartdesign.com
 * @author pest (pest11s@gmail.com)
 */

namespace app\models;

use Yii;
use yii\helpers\Html;

class Image extends File {

    public function getInitialPreview() {
        if(!empty($this->filename)) {
            return DIRECTORY_SEPARATOR . $this->filepath;
        } else {
            return '';
        }
    }
}