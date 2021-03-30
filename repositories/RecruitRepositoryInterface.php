<?php

namespace app\repositories;

use app\models\Recruit;

interface RecruitRepositoryInterface
{
    public function find($id);

    public function add(Recruit $recruit);

    public function save(Recruit $recruit);
}