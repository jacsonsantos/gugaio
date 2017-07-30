<?php
namespace JSantos\Event;

use JSantos\Libs\Mail;

/**
 * Class SendMailer
 * @package JSantos\Event
 */
class SendMailerEvent extends GIOEvent
{
    /**
     * @var string
     */
    protected $eventName = 'mailer';
    /**
     * @var Mail
     */
    public $mail;

    /**
     * SendMailer constructor.
     * @param Mail $mail
     */
    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * @param Mail $mail
     */
    public function setMail(Mail $mail)
    {
        $this->mail = $mail;
    }
}