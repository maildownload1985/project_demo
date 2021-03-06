<?php

namespace common\models\work;

use common\components\db\CeActivieRecord;

use Yii;

/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Calendar extends CeActivieRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'description'], 'required'],
            [['description'], 'string'],
            [['datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('work', 'ID'),
            'name' 				 => Yii::t('work', 'Event Calendar'),
            'description' 		 => Yii::t('work', 'Description'),
            'datetime_created' 	 => Yii::t('work', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('work', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('work', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('work', 'Disabled'),
        ];
    }
}
