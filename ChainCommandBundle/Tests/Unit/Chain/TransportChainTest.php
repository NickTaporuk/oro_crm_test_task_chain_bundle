<?php
/**
 * Created by IntelliJ IDEA.
 * User: nick
 * Date: 06.04.16
 * Time: 12:35
 */

namespace ChainCommandBundle\Tests\Unit\Chain;

use ChainCommandBundle\Chain\TransportChain;

class TransportChainTest extends \PHPUnit_Framework_TestCase {

    /** @var Command */
    protected $command;
    /** @var ChainTransport */
    protected $transport;
    /** @var Logger | \PHPUnit_Framework_MockObject_MockObject*/
    protected $logger;

    protected function setUp()
    {
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

    /**
     * @param string $nameCommand - name mock command
     * @dataProvider addDataTransport
     */

    public function testTransport($nameCommand)
    {
            $this->command->expects($this->any())
                ->method('getName')
                ->will(
                    $this->returnValue($nameCommand)
                );

            $this->transport->addTransport($this->command);
            $transports = $this->transport->getTransport();

            $this->assertNotEmpty($transports);
            $this->assertEquals($transports[0]->getName(), $nameCommand);

    }

    public function addDataTransport()
    {
        return [
            ['test:test'],
            ['test1:test'],
            ['test2:test'],
        ];
    }

}
