<?php

namespace app\repositories;

use app\models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    public function find($id)
    {
        if (!$contract = Contract::findOne($id)) {
            throw new \RuntimeException('Model not found.');
        }
        return $contract;
    }

    public function add(Contract $contract)
    {
        if (!$contract->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $contract->insert(false);
    }

    public function save(Contract $contract)
    {
        if ($contract->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $contract->update(false);
    }
}