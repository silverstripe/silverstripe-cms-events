<?php

namespace SilverStripe\CMSEvents\Tests\Listener\GridField\Action;

use PHPUnit\Framework\MockObject\Exception;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\EventDispatcher\Dispatch\Dispatcher;
use SilverStripe\EventDispatcher\Dispatch\EventDispatcherInterface;
use SilverStripe\EventDispatcher\Event\EventContextInterface;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Model\List\ArrayList;

class ListenerTest extends SapphireTest
{
    /**
     * @return void
     * @throws Exception
     * @throws HTTPResponse_Exception
     */
    public function testListener()
    {
        $req = new HTTPRequest(
            'POST',
            'mygrid',
            [],
            ['var' => 'value']
        );

        $grid = GridField::create(
            'myGrid',
            'My grid',
            ArrayList::create(),
            $config = new GridFieldConfig()
        );

        $config->addComponent(new URLHandlerFake());

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
                $this->equalTo('gridFieldAction'),
                $this->callback(function ($arg) use ($grid, $req) {
                    $this->assertInstanceOf(EventContextInterface::class, $arg);
                    $this->assertEquals('handleMyGrid', $arg->getAction());
                    $this->assertEquals($req, $arg->get('request'));
                    $this->assertEquals('my grid success', $arg->get('result'));
                    $this->assertEquals($grid, $arg->get('gridField'));

                    return true;
                })
            );
        Injector::inst()->registerService($dispatcherMock, Dispatcher::class);

        $grid->handleRequest($req);
    }
}
