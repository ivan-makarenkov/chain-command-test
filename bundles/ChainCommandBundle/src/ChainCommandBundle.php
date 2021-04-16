<?php

declare(strict_types=1);

namespace Ivmak\ChainCommandBundle;

use Ivmak\ChainCommandBundle\DependencyInjection\Compiler\ChainCommandRegistrationPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ChainCommandBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ChainCommandRegistrationPass());
    }

    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}