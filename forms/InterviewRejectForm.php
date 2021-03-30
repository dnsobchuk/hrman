<?php


namespace app\forms;


use yii\base\Model;

class InterviewRejectForm extends Model
{
    public $reason;

    /**
     * @return array
     */
    public function rules()
    {
        return [
          [['reason'], 'required'],
          [['reason'], 'string'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'reason' => 'Reject Reason',
        ];
    }

}