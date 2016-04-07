<?php
namespace ChainCommandBundle\Chain;

use Monolog\Logger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use ChainCommandBundle\Chain\ChainConsoleLogMessage;

class TransportChain
{
    /** @var $transports */
    protected $transports;
    /** @var string $masterProcess - name master process in chain*/
    protected $masterProcess;
    /** @var string $masterMessage - message master process for log file*/
    protected $masterMessage;
    /** @var Logger */
    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $this->transports = array();
    }

    /**
     * @param Command $transport
     */
    public function addTransport(Command $transport)
    {
            $this->transports[] = $transport;
    }

    /**
     * function execute chain and logging this
     */
    public function upChain()
    {

            $this->logger->debug(sprintf(ChainConsoleLogMessage::MESSAGE_LOG_MASTER,$this->getMasterProcess()));
            $this->logger->debug($this->getMasterMessageToLog());
            $this->logger->debug(sprintf(ChainConsoleLogMessage::MESSAGE_LOG_EXECUTING_MASTER,$this->getMasterProcess()));

            foreach($this->transports as $v) {
                if($this->logger) $this->logger->debug(sprintf(ChainConsoleLogMessage::MESSAGE_LOG_SLAVE,$v->getName(),$this->getMasterProcess()));
                $output = new BufferedOutput();
                $v->run(new ArrayInput([]),$output);
                $content = $output->fetch();
                $this->logger->debug($content);

                echo $content;
            }

            $this->logger->debug(sprintf(ChainConsoleLogMessage::MESSAGE_LOG_EXECUTING_ALL_COMMAND , $this->getMasterProcess()));
    }

    /**
     * @return array
     */
    public function getTransport()
    {
        return $this->transports;
    }

    /**
     * @param $masterProcessName
     */
    public function setMasterProcess($masterProcessName)
    {
        $this->masterProcess = $masterProcessName;
    }

    /**
     * @return mixed
     */
    public function getMasterProcess()
    {
        return $this->masterProcess;
    }

    /**
     * @param $masterMessage
     */
    public function setMasterMessageToLog($masterMessage)
    {
        $this->masterMessage = $masterMessage;
    }

    /**
     * @return mixed
     */
    public function getMasterMessageToLog()
    {
        return $this->masterMessage;
    }
}
