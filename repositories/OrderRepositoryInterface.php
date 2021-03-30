<?php

namespace app\repositories;

use app\models\Order;

interface OrderRepositoryInterface
{
    public function find($id);

    public function add(Order $order);

    public function save(Order $order);
}