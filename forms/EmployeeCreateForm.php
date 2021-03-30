<?php


namespace app\forms;


use app\models\Interview;
use yii\base\Model;

class EmployeeCreateForm extends Model
{
    public $firstName;
    public $lastName;
    public $address;
    public $email;
    public $orderDate;
    public $contractDate;
    public $recruitDate;
    public $interview;


    public function __construct(Interview $interview = null, $config = [])
    {
        $this->interview = $interview;
        parent::__construct($config);
    }

    public function init()
    {
        if($this->interview) {
            $this->firstName = $this->interview->first_name;
            $this->lastName = $this->interview->last_name;
            $this->email = $this->interview->email;
        }
        $this->orderDate = date('Y-m-d');
        $this->contractDate = date('Y-m-d');
        $this->recruitDate= date('Y-m-d');
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName', 'address'], 'required'],
            [['email'], 'email'],
            [['firstName', 'lastName', 'address', 'email'], 'string', 'max' => 255],
            [['orderDate', 'contractDate', 'recruitDate'], 'required'],
            [['orderDate', 'contractDate', 'recruitDate'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'address' => 'Address',
            'email' => 'Email',
            'orderDate' => 'Order Date',
            'contractDate' => 'Contract Date',
            'recruitDate' => 'Recruit Date',
        ];
    }

}