<?php

namespace app\services;


/**
 * Class Logger
 * @package app\services
 */
interface LoggerInterface
{
    /**
     * @param $message
     */
    public function log($message);
}