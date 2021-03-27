<?php

namespace app\repositories;

use app\models\Interview;

class InterviewRepository implements InterviewRepositoryInterface
{
    public function find($id)
    {
        if (!$interview = Interview::findOne($id)) {
            throw new \RuntimeException('Model not found.');
        }
        return $interview;
    }

    public function add(Interview $interview)
    {
        if (!$interview->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $interview->insert(false);
    }

    public function save(Interview $interview)
    {
        if ($interview->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $interview->update(false);
    }
}