<?php

namespace app\repositories;

use app\models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function find($id)
    {
        if (!$order = Order::findOne($id)) {
            throw new \RuntimeException('Model not found.');
        }
        return $order;
    }

    public function add(Order $order)
    {
        if (!$order->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $order->insert(false);
    }

    public function save(Order $order)
    {
        if ($order->getIsNewRecord()) {
            throw new \RuntimeException('Model not exist.');
        }
        $order->update(false);
    }
}