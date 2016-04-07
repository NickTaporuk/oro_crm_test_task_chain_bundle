<?php

namespace ChainCommandBundle;

use ChainCommandBundle\DependencyInjection\Compiler\ConsoleTransport;
use ChainCommandBundle\DependencyInjection\Compiler\SlaveDetect;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChainCommandBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConsoleTransport());
    }
}
