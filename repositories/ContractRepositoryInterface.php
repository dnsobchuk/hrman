<?php

namespace app\repositories;

use app\models\Contract;

interface ContractRepositoryInterface
{
    public function find($id);

    public function add(Contract $contract);

    public function save(Contract $contract);
}