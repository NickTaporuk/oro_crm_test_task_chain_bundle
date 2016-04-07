<?php

namespace ChainCommandBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ConsoleTransport
 * @package ChainCommandBundle\DependencyInjection\Compiler
 */
class ConsoleTransport implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('chain_command.transport_chain')) {
            return;
        }

        $definition = $container->findDefinition(
            'chain_command.transport_chain'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'chain_command.transport'
        );

        foreach ($taggedServices as $id => $tags) {
            if ($container->hasDefinition($id)) {
                $container->getDefinition($id)->setPublic(false);
            }
            if (!$container->getDefinition($id)->isPublic()) {
//                $class = $container->getParameterBag()->resolveValue($definition->getClass());
            }
            $params = [new Reference($id)];
            if (!empty($tagAttributes[0]['priority'])) {
                $params[] = (int) $tagAttributes[0]['priority'];
            }

            $definition->addMethodCall(
                'addTransport',
                $params
            );
        }
    }
}
