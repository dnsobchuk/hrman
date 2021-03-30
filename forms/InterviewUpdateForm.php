<?php


namespace app\forms;


use app\models\Interview;
use yii\base\Model;

class InterviewUpdateForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;
    public $interview;

    public function __construct(Interview $interview, $config = [])
    {
        $this->interview = $interview;
        parent::__construct($config);
    }

    public function init()
    {
        $this->firstName = $this->interview->first_name;
        $this->lastName = $this->interview->last_name;
        $this->email = $this->interview->email;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
          [['firstName', 'lastName'], 'required'],
          [['email'], 'email'],
          [['firstName', 'lastName', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
        ];
    }

}