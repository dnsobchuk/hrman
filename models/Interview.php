<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "interview".
 *
 * @property int $id
 * @property string $date
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property int $status
 * @property string|null $reject_reason
 * @property int|null $employee_id
 *
 * @property Employee $employee
 */
class Interview extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PASS => 'Passed',
            self::STATUS_REJECT => 'Rejected',
        ];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $date
     * @return self
     */
    public static function create($firstName, $lastName, $email, $date) {
        $interview = new self;
        $interview->date = $date;
        $interview->first_name = $firstName;
        $interview->last_name = $lastName;
        $interview->email = $email;
        $interview->status = self::STATUS_NEW;
        return $interview;
    }

    public function editData($lastName, $firstName, $email)
    {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
    }

    public function move($date) {
        $this->guardNotCurrentDate($date);
        $this->date = $date;
    }

    public function reject($reason)
    {
        $this->guardNotRejected();
        $this->reject_reason = $reason;
        $this->status = self::STATUS_REJECT;
    }

    public static function tableName()
    {
        return 'interview';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'status' => 'Status',
            'reject_reason' => 'Reject Reason',
            'employee_id' => 'Employee ID',
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    private function guardNotRejected()
    {
        if($this->status == self::STATUS_REJECT) {
            throw new \RuntimeException('Interview is already rejected');
        }
    }
    private function guardNotCurrentDate($date)
    {
        if($this->date == $date) {
            throw new \RuntimeException('Date is current');
        };
    }

    public function isRecruitable()
    {
        return $this->status == self::STATUS_PASS;
    }
}
