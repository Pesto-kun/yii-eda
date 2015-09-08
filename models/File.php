<?php

namespace app\models;

use Yii;

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
 * @property FoodType[] $foodTypes
 */
class File extends \yii\db\ActiveRecord
{
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
            [['status', 'filesize'], 'integer'],
            [['created'], 'safe'],
            [['filename', 'filepath', 'filemime', 'filesize'], 'required'],
            [['filename', 'filepath', 'filemime'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'created' => 'Created',
            'filename' => 'Filename',
            'filepath' => 'Filepath',
            'filemime' => 'Filemime',
            'filesize' => 'Filesize',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodTypes()
    {
        return $this->hasMany(FoodType::className(), ['image_id' => 'id']);
    }
}
