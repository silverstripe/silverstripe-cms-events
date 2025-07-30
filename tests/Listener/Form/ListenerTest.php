<?php

namespace SilverStripe\CMSEvents\Tests\Listener\Form;

use PHPUnit\Framework\MockObject\Exception;
use SilverStripe\Admin\LeftAndMainFormRequestHandler;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\EventDispatcher\Dispatch\Dispatcher;
use SilverStripe\EventDispatcher\Dispatch\EventDispatcherInterface;
use SilverStripe\EventDispatcher\Event\EventContextInterface;
use SilverStripe\CMSEvents\Tests\Listener\CMSMain\CMSMainFake;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class ListenerTest extends SapphireTest
{
    /**
     * @return void
     * @throws Exception
     * @throws HTTPResponse_Exception
     */
    public function testListener()
    {
        $form = Form::create(
            CMSMainFake::create(),
            FieldList::create(),
            FieldList::create(
                $action = FormAction::create('myFormAction', 'My form action')
            )
        )->disableSecurityToken();

        $req = new HTTPRequest(
            'POST',
            '',
            [],
            [$action->getName() => $action->getName()]
        );

        $dispatcherMock = $this->getMockBuilder(Dispatcher::class)
            ->setConstructorArgs([
                $this->createMock(EventDispatcherInterface::class)
            ])
            ->onlyMethods([
                'trigger',
            ])
            ->getMock();
        $dispatcherMock->expects($this->once())
            ->method('trigger')
            ->with(
                $this->equalTo('formSubmitted'),
                $this->callback(function ($arg) use ($form, $req) {
                    $this->assertInstanceOf(EventContextInterface::class, $arg);
                    $this->assertEquals('myFormAction', $arg->getAction());
                    $this->assertEquals($form, $arg->get('form'));
                    $this->assertEquals($req, $arg->get('request'));
                    $this->assertEquals($req->postVars(), $arg->get('vars'));

                    return true;
                })
            );
        Injector::inst()->registerService($dispatcherMock, Dispatcher::class);

        $requestHandler = LeftAndMainFormRequestHandler::create($form);
        $requestHandler->httpSubmission($req);
    }
}
