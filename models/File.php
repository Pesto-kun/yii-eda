<?php

namespace app\models;

use Exception;
use Yii;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property integer $status
 * @property string $created
 * @property string $filename
 * @property string $filepath
 * @property string $filemime
 * @property integer $filesize
 *
 */
class File extends \yii\db\ActiveRecord
{
    const FILE_ENABLED = 1;
    const FILE_DISABLED = 0;

    protected $_coreFileDir = 'uploads/';

    protected $_fileDir = '';
    protected $_newFileName;

    /**
     * @var $_file UploadedFile
     */
    protected $_file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }

    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @param UploadedFile $file
     *
     * @return $this
     */
    public function setFile($file) {
        $this->_file = $file;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile() {
        return $this->_file;
    }

    /**
     * @return string
     */
    public function getFileDir() {
        return $this->_fileDir ? trim($this->_fileDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR : '';
    }

    /**
     * @param string $fileDir
     *
     * @return $this
     */
    public function setFileDir($fileDir) {
        $this->_fileDir = $fileDir;
        return $this;
    }

    /**
     * Получение нового имени файла
     *
     * @return string
     * @throws Exception
     */
    public function getNewFileName() {
        if(is_null($this->_newFileName)) {

            $i = 0;
            do {
                //Выходим из цикла при достаточно большом количестве сгенерировать имя файла
                if($i > 1000) {
                    throw new Exception('Превышен лимит попыток генерации имени для файла.');
                }

                $newFileName = md5($i++.$this->getFile()->name) . '.' . $this->getFile()->extension;

            } while($this->checkFileExist($newFileName));

            BaseFileHelper::createDirectory(dirname($this->getFilePath($newFileName)));
            $this->_newFileName = $newFileName;
        }
        return $this->_newFileName;
    }

    /**
     * Получение полного пути к файлу на сервере
     *
     * @param $filePath
     *
     * @return string
     */
    protected function getRealFilePath($filePath) {
        return Yii::getAlias('@webroot/'.$filePath);
    }

    /**
     * Проверка существования файла
     *
     * @param $fileName
     *
     * @return bool
     */
    public function checkFileExist($fileName) {
        return file_exists($this->getRealFilePath($this->getFilePath($fileName)));
    }

    /**
     * Получение локального пути файла
     *
     * @param $fileName
     *
     * @return string
     * @throws Exception
     */
    public function getFilePath($fileName) {
        return $this->_coreFileDir . $this->getFileDir() . $this->getFileNameWithSubDirs($fileName);
    }

    /**
     * создание поддиректорий
     *
     * @param $fileName
     *
     * @return string
     */
    protected function getFileNameWithSubDirs($fileName) {
        return (isset($fileName[1]) ?
            $fileName[0] . DIRECTORY_SEPARATOR . $fileName[1] :
            '_' . $fileName[0]) . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Загрузка файла
     *
     * @param $model
     * @param $attribute
     *
     * @return $this
     */
    public function uploadFile($model, $attribute) {
        $this->setFile(UploadedFile::getInstance($model, $attribute));
        return $this;
    }

    /**
     * Проверка, что модуль файла загружена
     *
     * @return bool
     */
    public function isFileUploaded() {
        return !is_null($this->getFile());
    }

    /**
     * Сохранение загруженного файла
     *
     * @param string $directory
     *
     * @return bool
     */
    public function saveFile($directory = '') {
        try {

            $this->setFileDir($directory);

            $this->status = self::FILE_ENABLED;
            $this->filename = $this->getNewFileName();
            $this->filesize = $this->getFile()->size;
            $this->filemime = $this->getFile()->type;
            $this->filepath = $this->getFilePath($this->getNewFileName());
            if($this->getFile()->saveAs($this->filepath)) {
                return $this->save();
            }
        } catch(Exception $e) {
            //TODO
        }
        return false;
    }

    public function delete() {

        //Если модель была удалена
        if(parent::delete()) {
            //Удаляем файл
            try {
                unlink($this->getRealFilePath($this->_coreFileDir . $this->filepath));
                return true;
            } catch(Exception $e) {
                //TODO
            }
        }

        return false;
    }
}
