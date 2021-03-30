<?php


namespace app\forms;


use app\models\Interview;
use yii\base\Model;

class InterviewMoveForm extends Model
{
    public $date;
    public $interview;

    public function __construct(Interview $interview, $config = [])
    {
        $this->interview = $interview;
        parent::__construct($config);
    }

    public function init()
    {
        $this->date = $this->interview->date;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
          [['date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'New Date',
        ];
    }

}