<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $to;

    public function __construct(\Swift_Mailer $mailer,string $to)
    {
        $this->mailer = $mailer;
        $this->to = $to;
    }

    public static function getSubscribedEvents()
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event)
    {
        $message = new \Swift_Message();
        $this->mailer->send($message);
    }
}
