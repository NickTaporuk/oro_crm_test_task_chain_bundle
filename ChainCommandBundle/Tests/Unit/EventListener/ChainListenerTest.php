<?php

namespace ChainCommandBundle\Tests\Unit\EventListener;

use ChainCommandBundle\EventListener\ChainListener;
use Symfony\Component\DependencyInjection\Container;
use ChainCommandBundle\Chain\TransportChain;

class ChainListenerTest extends \PHPUnit_Framework_TestCase {

    /** @var ChainListener */
    protected $listener;
    /** @var Container | \PHPUnit_Framework_MockObject_MockObject */
    protected $container;
    /** @var Command | \PHPUnit_Framework_MockObject_MockObject*/
    protected $command;
    /** @var string $nameTestCommand*/
    protected $nameTestCommand = 'test:test';
    /** @var string $nameTestCommand*/
    protected $nameRealName = 'chain_command.transport_chain';
    /** @var Logger | \PHPUnit_Framework_MockObject_MockObject*/
    protected $logger;

    protected function setUp()
    {
        $this->container = $this->getMockBuilder('Symfony\Component\DependencyInjection\Container')
            ->getMock();

        $this->command = $this->getMockBuilder('Symfony\Component\Console\Command\Command')
            ->disableOriginalConstructor()
            ->getMock();

        $this->logger = $this->getMockBuilder('Monolog\Logger')
            ->disableOriginalConstructor()
            ->getMock();

        $this->logger->expects($this->any())
            ->method('debug')
            ->will(
                $this->returnValue('')
            );

        $this->transport = new TransportChain($this->logger);

    }

    public function testOnChainCommand()
    {
        $this->command->expects($this->any())
            ->method('getName')
            ->will(
                $this->returnValue($this->nameTestCommand)
            );

        $this->command->expects($this->any())
            ->method('getSynopsis')
            ->will(
                $this->returnValue($this->nameTestCommand)
            );

        $this->transport->addTransport($this->command);

        $this->container->expects($this->any())
            ->method('get')
            ->will(
                $this->returnValue($this->transport)
            );

        $eventConsole = $this->getMockBuilder('Symfony\Component\Console\Event\ConsoleCommandEvent')
                                ->disableOriginalConstructor()
                                ->getMock();

        $eventConsole->expects($this->any())
            ->method('getCommand')
            ->will(
                $this->returnValue($this->command)
            );

        $this->listener = new ChainListener($this->container);
        $this->listener->onChainCommand($eventConsole);
    }

    public function testOnTerminateCommand()
    {
        $this->command->expects($this->any())
            ->method('getName')
            ->will(
                $this->returnValue($this->nameTestCommand)
            );

        $this->command->expects($this->any())
            ->method('getSynopsis')
            ->will(
                $this->returnValue($this->nameTestCommand)
            );

        $this->transport->addTransport($this->command);

        $this->container->expects($this->any())
            ->method('get')
            ->will(
                $this->returnValue($this->transport)
            );

        $eventConsole = $this->getMockBuilder('Symfony\Component\Console\Event\ConsoleTerminateEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $eventConsole->expects($this->any())
            ->method('getCommand')
            ->will($this->returnValue($this->command)
            );

        $eventConsole->expects($this->any())
            ->method('getExitCode')
            ->will($this->returnValue(113)
            );

        $this->listener = new ChainListener($this->container);
        $this->listener->setVisibleExceptionMessageConsole(false);
        $this->assertFalse($this->listener->onTerminateCommand($eventConsole));
    }
}
