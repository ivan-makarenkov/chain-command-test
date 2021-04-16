<?php

declare(strict_types=1);

namespace Ivmak\ChainCommandBundle\DependencyInjection\Compiler;

use Ivmak\ChainCommandBundle\Service\ChainCommandManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ChainCommandRegistrationPass implements CompilerPassInterface
{
    /**
     * We use CompilerPass to find all commands that implements our ChainCommandInterface
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ChainCommandManager::class)) {
            return;
        }

        $exporterManagerDefinition = $container->findDefinition(ChainCommandManager::class);

        $taggedServices = $container->findTaggedServiceIds('ivmak.chain.command');

        $commandReferences = [];
        foreach ($taggedServices as $id => $tags) {
            $commandReferences[] = new Reference($id);
        }

        $exporterManagerDefinition->setArguments(['$commands' => $commandReferences]);
    }
}