<?php

namespace common\models\work;

use common\components\db\CeActivieRecord;

use Yii;

/**
 * This is the model class for table "invitation".
 *
 * @property string $id
 * @property string $event_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Invitation extends CeActivieRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invitation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id'], 'required'],
            [['event_id', 'owner_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['disabled'], 'boolean'],
            [['owner_table'], 'string', 'max' => 99]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('work', 'ID'),
            'event_id' 			 => Yii::t('work', 'Event ID'),
            'owner_id' 			 => Yii::t('work', 'Owner ID'),
            'owner_table' 		 => Yii::t('work', 'Owner Table'),
            'datetime_created'   => Yii::t('work', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('work', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('work', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('work', 'Disabled'),
        ];
    }
}
