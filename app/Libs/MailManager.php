<?php
namespace JSantos\Libs;

use JSantos\Event\SendMailerEvent as SendMailer;
use Pimple\Container;

class MailManager
{
    private $mail;

    private $app;

    private $data = [];

    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->mail = new Mail();
    }

    public function setMail(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function make(array $data = [])
    {
        $this->data = $data ?? $this->data;
        $this->mail->setSubject($this->data['subject']);
        $this->mail->setFrom($this->data['from']);
        $this->mail->setTo($this->data['to']);
        $this->mail->setBody($this->data['body']);

        return $this;
    }
    public function run()
    {
        $event = new SendMailer($this->mail);
        $this->app['dispatcher']->dispatch($event->getEventName(),$event);
        $this->app['monolog']->notice("Desparou o Event: {$event->getEventName()}");
    }

    public function build(array $data)
    {
        $this->make($data)->run();
    }
}