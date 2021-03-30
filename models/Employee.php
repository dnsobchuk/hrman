<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string|null $email
 * @property int $status
 *
 * @property Assignment[] $assignments
 * @property Bonus[] $bonuses
 * @property Dismiss[] $dismisses
 * @property Interview[] $interviews
 * @property Recruit[] $recruits
 * @property Vacation[] $vacations
 */
class Employee extends \yii\db\ActiveRecord
{
    const STATUS_PROBATION = 1;
    const STATUS_WORK = 2;
    const STATUS_VACATION = 3;
    const STATUS_DISMISS = 4;

    public static function getStatusList()
    {
        return [
            self::STATUS_PROBATION => 'Probation',
            self::STATUS_WORK => 'Work',
            self::STATUS_VACATION => 'Vacation',
            self::STATUS_DISMISS => 'Dismiss',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * @param $firstName
     * @param $lastName
     * @param $address
     * @param $email
     * @return self
     */
    public static function create($firstName, $lastName, $address, $email) {
        $employee = new self;
        $employee->first_name = $firstName;
        $employee->last_name = $lastName;
        $employee->address = $address;
        $employee->email = $email;
        $employee->status = self::STATUS_PROBATION;
        return $employee;
    }

    /**
     * Gets query for [[Assigments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssigments()
    {
        return $this->hasMany(Assignment::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Bonuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBonuses()
    {
        return $this->hasMany(Bonus::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Dismisses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDismisses()
    {
        return $this->hasMany(Dismiss::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Interviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Recruits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecruits()
    {
        return $this->hasMany(Recruit::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Vacations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacations()
    {
        return $this->hasMany(Vacation::className(), ['employee_id' => 'id']);
    }
}
