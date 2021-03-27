<?php


namespace app\services;

use Yii;

/**
 * Class Notifier
 * @package app\services
 */
class Notifier implements NotifierInterface
{
    /**
     * @param $view
     * @param $data
     * @param $email
     * @param $subject
     */
    public function notify($view, $data, $email, $subject)
    {
        Yii::$app->mailer
            ->compose($view, $data)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($email)
            ->setSubject($subject)
            ->send();
    }
}