<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use Ivmak\ChainCommandBundle\Model\ChainCommandInitiatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitiatorCommand extends Command implements ChainCommandInitiatorInterface
{
    public const COMMAND_NAME = 'test:initiator';

    public function __construct(){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Command to test initiators of Chain Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Test initiator');
        return 0;
    }

    public function getName(): string
    {
        return self::COMMAND_NAME;
    }
}
