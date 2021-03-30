<?php

namespace app\repositories;

use app\models\Employee;

interface EmployeeRepositoryInterface
{
    public function find($id);

    public function add(Employee $interview);

    public function save(Employee $interview);
}