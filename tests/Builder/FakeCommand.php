<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use Ivmak\ChainCommandBundle\Model\ChainCommandFollowerInterface;
use Ivmak\ChainCommandBundle\Model\ChainCommandInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeCommand implements ChainCommandInterface
{
    public function getName(): string
    {
        return 'fake';
    }
}
