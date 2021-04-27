<?php

declare(strict_types=1);

namespace App\FooBundle\Command;

use Ivmak\ChainCommandBundle\Model\ChainCommandInitiatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command implements ChainCommandInitiatorInterface
{
    public const COMMAND_NAME = 'foo:hello';

    public function __construct(){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Command Foo Hello');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello from Foo!');
        return 0;
    }

    public function getName(): string
    {
        return self::COMMAND_NAME;
    }
}
