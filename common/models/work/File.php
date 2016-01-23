<?php

namespace common\models\work;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $owner_id
 * @property string $employee_id
 * @property string $owner_object
 * @property string $name
 * @property string $encoded_name
 * @property string $path
 * @property boolean $is_image
 * @property string $file_type
 * @property string $file_size
 * @property string $lastup_datetime
 * @property string $datetime_created
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class File extends \yii\db\ActiveRecord
{
	
	public $imageFiles;
	
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
            [['owner_id', 'owner_object', 'name', 'encoded_name', 'path'], 'required'],
            [['owner_id', 'employee_id', 'file_size', 'lastup_datetime', 'datetime_created', 'lastup_employee_id'], 'integer'],
            [['path'], 'string'],
            [['is_image', 'disabled'], 'boolean'],
            [['owner_object', 'name', 'encoded_name', 'file_type'], 'string', 'max' => 255],
        	[['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Owner ID',
            'employee_id' => 'Employee ID',
            'owner_object' => 'Owner Object',
            'name' => 'Name',
            'encoded_name' => 'Encoded Name',
            'path' => 'Path',
            'is_image' => 'Is Image',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'lastup_datetime' => 'Lastup Datetime',
            'datetime_created' => 'Datetime Created',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
    
    public function upload()
    {
    	if ($this->validate()) {
    		foreach ($this->imageFiles as $file) {
    			$file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
    		}
    		return true;
    	} else {
    		return false;
    	}
    }
}
