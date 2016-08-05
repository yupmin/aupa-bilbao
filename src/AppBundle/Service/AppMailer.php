<?php

namespace AppBundle\Service;

class AppMailer
{
    private $mailer;

    /**
     * AppMailer constructor.
     * @param \Swift_Mailer $mailer
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $text
     * @return mixed
     */
    public function sendEmail($to, $subject, $text)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('noreply@aupa-bilbao.app')
            ->setTo($to)
            ->setBody($text)
        ;

        return $this->mailer->send($message);
    }
}
