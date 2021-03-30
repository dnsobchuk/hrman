<?php

namespace app\repositories;

use app\models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function find($id)
    {
        if (!$employee = Employee::findOne($id)) {
            throw new \RuntimeException('Model not found.');
        }
        return $employee;
    }

    public function add(Employee $employee)
    {
        if (!$employee->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $employee->insert(false);
    }

    public function save(Employee $employee)
    {
        if ($employee->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $employee->update(false);
    }
}