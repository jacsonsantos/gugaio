<?php
namespace JSantos\Listener;

use JSantos\Event\SendMailer;

/**
 * Class MailerListener
 * @package JSantos\Listener
 */
class MailerListener extends GIOListener
{
    /**
     * @param SendMailer $event
     * @throws \Exception
     */
    public function onSend(SendMailer $event)
    {
        $message = \Swift_Message::newInstance();
        $message = $message->setSubject($event->mail->getSubject())
            ->setFrom($event->mail->getFrom())
            ->setBody($event->mail->getBody(),'text/html')
            ->setTo($event->mail->getTo());

        if (!$this->app['mailer']->send($message)) {
            $this->app['monolog']->error("Não foi possivel enviar email para: {$event->mail->getTo()}");
            throw new \Exception("Erro ao enviar e-mail para: ".$$event->mail->getTo(), 1);
        } else {
            $this->app['monolog']->notice("Enviou Email para: {$event->mail->getTo()}");
        }

    }
}