<?php

namespace common\models\work;

use common\components\db\CeActivieRecord;

use Yii;

/**
 * This is the model class for table "remind".
 *
 * @property string $id
 * @property string $employee_id
 * @property string $owner_id
 * @property string $owner_table
 * @property string $content
 * @property string $remind_datetime
 * @property string $minute_before
 * @property string $repeated_time
 * @property boolean $is_snoozing
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $is_remind
 */
class Remind extends CeActivieRecord
{
	public $is_remind;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'remind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'owner_id', 'remind_datetime', 'minute_before', 'repeated_time', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['content'], 'string'],
            [['is_snoozing', 'is_remind'], 'boolean'],
            [['owner_table'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('work', 'ID'),
            'employee_id' 		 => Yii::t('work', 'Employee ID'),
            'owner_id' 			 => Yii::t('work', 'Owner ID'),
            'owner_table' 		 => Yii::t('work', 'Owner Table'),
            'content' 			 => Yii::t('work', 'Content'),
            'remind_datetime' 	 => Yii::t('work', 'Remind Datetime'),
            'minute_before' 	 => Yii::t('work', 'Minute Before'),
            'repeated_time' 	 => Yii::t('work', 'Repeated Time'),
            'is_snoozing' 		 => Yii::t('work', 'Is Snoozing'),
            'datetime_created'   => Yii::t('work', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('work', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('work', 'Lastup Employee ID'),
            'is_remind' 	 	 => Yii::t('work', 'is_remind'),
        ];
    }
    
    /**
     * @description show option time 10 20 30 40 50 60
     * @author minhtha
     * @return array time
     */
    public static function getTimeRemind(){
    	return [
    	'10' => '10',
    	'20' => '20',
    	'30' => '30',
    	'40' => '40',
    	'50' => '50',
    	'60' => '60',
    	];
    }
}
