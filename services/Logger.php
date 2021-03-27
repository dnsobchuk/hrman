<?php

namespace app\services;

use app\models\Log;

/**
 * Class Logger
 * @package app\services
 */
class Logger implements LoggerInterface
{
    /**
     * @param $message
     */
    public function log($message)
    {
        $log = new Log();
        $log->message = $message;
        $log->save(false);
    }
}