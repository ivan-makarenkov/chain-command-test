<?php

declare(strict_types=1);

namespace App\BarBundle\Command;

use App\FooBundle\Command\HelloCommand;
use Ivmak\ChainCommandBundle\Model\ChainCommandFollowerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HiCommand extends Command implements ChainCommandFollowerInterface
{
    public const COMMAND_NAME = 'bar:hi';

    public function __construct(){
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Command Bar Hi');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hi from Bar!');
        return 0;
    }


    public function getPriority(): int
    {
        return 1;
    }

    public function getParent(): string
    {
        return HelloCommand::COMMAND_NAME;
    }

    public function getName(): string
    {
        return self::COMMAND_NAME;
    }
}
