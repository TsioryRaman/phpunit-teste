<?php

namespace App\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use App\EventSubscriber\ExceptionSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class ExceptionSubscriberTest extends TestCase
{

    public function testEventSubscription(){
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }

    public function testOnExceptionSendEmail(){
        $mailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $subscriber = new ExceptionSubscriber($mailer, 'from@domain.fr','to@domain.fr');
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $event = new ExceptionEvent($kernel,new Request(),1,new \Exception());

        $mailer->expects($this->once())->method('send');

        // $subscriber->onException($event);
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);


    }
}