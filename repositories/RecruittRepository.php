<?php

namespace app\repositories;

use app\models\Recruit;

class RecruitRepository implements RecruitRepositoryInterface
{
    public function find($id)
    {
        if (!$recruit = Recruit::findOne($id)) {
            throw new \RuntimeException('Model not found.');
        }
        return $recruit;
    }

    public function add(Recruit $recruit)
    {
        if (!$recruit->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $recruit->insert(false);
    }

    public function save(Recruit $recruit)
    {
        if ($recruit->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $recruit->update(false);
    }
}