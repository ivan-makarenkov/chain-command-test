<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use Ivmak\ChainCommandBundle\Model\ChainCommandFollowerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FollowerCommand extends Command implements ChainCommandFollowerInterface
{
    public const COMMAND_NAME = 'test:follower';

    public function __construct(){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Command to test followers of Chain Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Test follower');
        return 0;
    }

    public function getPriority(): int
    {
        return 12;
    }

    public function getParent(): string
    {
        return InitiatorCommand::COMMAND_NAME;
    }

    public function getName(): string
    {
        return self::COMMAND_NAME;
    }
}
