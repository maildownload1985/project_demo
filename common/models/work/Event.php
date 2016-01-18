<?php
/**
 * @author minh-tha
 * @create date 2016-01-06
 */

namespace common\models\work;

use Yii;
use common\components\db\CeActivieRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property integer $calendar_id
 * @property string $employee_id
 * @property string $name
 * @property string $description
 * @property string $description_parse
 * @property string $address
 * @property string $start_datetime
 * @property integer $end_datetime
 * @property boolean $is_public
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class Event extends CeActivieRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'employee_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['employee_id', 'name', 'description', 'description_parse', 'start_datetime', 'end_datetime', 'address' ], 'required'],
            [['description', 'description_parse'], 'string'],
            [['is_public', 'disabled'], 'boolean'],
            [['start_datetime', 'end_datetime'], 'safe'],
            ['start_datetime','compare','compareAttribute'=>'end_datetime','operator'=>'>'],
            [['name', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' 				 => Yii::t('work', 'ID'),
            'calendar_id' 		 => Yii::t('work', 'Calendar ID'),
            'employee_id' 		 => Yii::t('work', 'Employee ID'),
            'name' 				 => Yii::t('work','Name'),
            'description' 		 => Yii::t('work', 'Description'),
            'description_parse'  => Yii::t('work', 'Description Parse'),
            'address' 			 => Yii::t('work', 'Address'),
            'start_datetime' 	 => Yii::t('work', 'Start Datetime'),
            'end_datetime' 		 => Yii::t('work', 'End Datetime'),
            'is_public' 		 => Yii::t('work', 'Is Public'),
            'datetime_created' 	 => Yii::t('work', 'Datetime Created'),
            'lastup_datetime' 	 => Yii::t('work', 'Lastup Datetime'),
            'lastup_employee_id' => Yii::t('work', 'Lastup Employee ID'),
            'disabled' 			 => Yii::t('work', 'Disabled'),
        ];
    }
    
    public static function getDepartmentNameCheckBox()
    {
    	return ArrayHelper::map(Department::find()->asArray()->all(), 'id', 'name');
    }
    
    public static function getCalendarOption()
    {
    	return ArrayHelper::map(Calendar::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getEventCalendar() {
        $data = $this->find()->asArray()->all();
        return $data;
    }
    
    /**
     * insert event
     */
    public function insertEvent($post) {
        $this->calendar_id = 0;
        $this->employee_id = 0;
        $this->name = $post['Event']['name'];
        $this->description = $post['Event']['description'];
        $this->description_parse = $post['Event']['description'];
        $this->address = 'test';
        $this->start_datetime = 0;
        $this->end_datetime = 0;
        $this->is_public = $post['Event']['is_public'];
        $this->datetime_created = '1452163538';
        $this->lastup_datetime = '1452163538';
        $this->lastup_employee_id = 0;
        $this->disabled = 0;
        
        return $this->save();
        
    }
}
