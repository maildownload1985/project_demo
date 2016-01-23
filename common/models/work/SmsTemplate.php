<?php

namespace common\models\work;

use Yii;

/**
 * This is the model class for table "sms_template".
 *
 * @property integer $id
 * @property integer $sending_template_group_id
 * @property string $body
 * @property string $column_name
 * @property string $default_from_phone_no
 * @property string $datetime_created
 * @property string $lastup_datetime
 * @property string $lastup_employee_id
 * @property boolean $disabled
 */
class SmsTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sms_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sending_template_group_id', 'body', 'column_name'], 'required'],
            [['sending_template_group_id', 'datetime_created', 'lastup_datetime', 'lastup_employee_id'], 'integer'],
            [['body'], 'string'],
            [['disabled'], 'boolean'],
            [['column_name'], 'string', 'max' => 99],
            [['default_from_phone_no'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sending_template_group_id' => 'Sending Template Group ID',
            'body' => 'Body',
            'column_name' => 'Column Name',
            'default_from_phone_no' => 'Default From Phone No',
            'datetime_created' => 'Datetime Created',
            'lastup_datetime' => 'Lastup Datetime',
            'lastup_employee_id' => 'Lastup Employee ID',
            'disabled' => 'Disabled',
        ];
    }
}
