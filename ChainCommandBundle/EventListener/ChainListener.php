<?php
namespace ChainCommandBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use ChainCommandBundle\Chain\ChainConsoleLogMessage;

/**
 * Class ChainListener
 * @package ChainCommandBundle\EventListener
 */
class ChainListener implements EventSubscriberInterface
{

    /** @var Container $container */
    protected $container;
    /** @var bool $visibleExceptionMessageConsole */
    public $visibleExceptionMessageConsole = true ;

    /** @param Container $container */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /** @param ConsoleCommandEvent $event */
    public function onChainCommand(ConsoleCommandEvent $event)
    {
            $ch = $this->container->get('chain_command.transport_chain');
            $transports = $ch->getTransport();
            foreach($transports as $k=>$v) {
                if($v->getSynopsis() == $event->getCommand()->getName())
                {
                    $event->disableCommand();
                }
            }
    }

    /**
     * Listen exit code 113
     * and if == 113
     * return message in console
     *
     * @param ConsoleTerminateEvent $event
     * @return bool|void
     */
    public function onTerminateCommand(ConsoleTerminateEvent $event)
    {
        try {
            $statusCode = $event->getExitCode();
            if ($statusCode === 0) {
                return;
            }

            if ($statusCode > 255) {
                $statusCode = 255;
                $event->setExitCode($statusCode);
            }
            if($statusCode == 113) {
                $ch = $this->container->get('chain_command.transport_chain');
                $transports = $ch->getTransport();
                foreach($transports as $k=>$v) {
                    if($v->getSynopsis() == $event->getCommand()->getName())
                    {
                        $master = $this->container->getParameter('chain_command.chain');

                        throw new \Exception(sprintf(ChainConsoleLogMessage::MESSAGE_ERROR_SLAVE,$event->getCommand()->getName(),$master));
                    }
                }
            }
        } catch(\Exception $e) {
            if($this->isVisibleExceptionMessageConsole()) echo $e->getMessage();
            return false;
        }
    }

    /** @return array */
    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND  => 'onChainCommand',
            ConsoleEvents::TERMINATE=> 'onTerminateCommand',
        ];
    }

    /**
     * @return boolean
     */
    public function isVisibleExceptionMessageConsole()
    {
        return $this->visibleExceptionMessageConsole;
    }

    /**
     * @param boolean $visibleExceptionMessageConsole
     */
    public function setVisibleExceptionMessageConsole($visibleExceptionMessageConsole)
    {
        $this->visibleExceptionMessageConsole = $visibleExceptionMessageConsole;
    }


}