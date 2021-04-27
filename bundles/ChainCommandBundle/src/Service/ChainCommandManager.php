<?php

declare(strict_types=1);

namespace Ivmak\ChainCommandBundle\Service;

use Ivmak\ChainCommandBundle\Exception\RuntimeException;
use Ivmak\ChainCommandBundle\Model\ChainCommandFollowerInterface;
use Ivmak\ChainCommandBundle\Model\ChainCommandInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Class ChainCommandManager
 * @package Ivmak\ChainCommandBundle\Service
 */
class ChainCommandManager
{
    private array $followers;

    /**
     * ChainCommandManager constructor.
     * @param LoggerInterface $logger
     * @param ChainCommandInterface[] $commands
     */
    public function __construct(private LoggerInterface $logger, private iterable $commands = [])
    {
        $this->commands = [];
        $this->followers = [];
        foreach ($commands as $command) {
            $this->registerCommand($command);
        }
    }

    /**
     * This method registers commands and save followed command list.
     * @param ChainCommandInterface $command
     */
    public function registerCommand(ChainCommandInterface $command): void
    {
        if (!$command instanceof Command) {
            throw new RuntimeException('Wrong class implemented as a Chain Command');
        }

        $this->commands[$command->getName()] = $command;

        if ($command instanceof ChainCommandFollowerInterface) {
            $this->logger->info(sprintf("%s registered as a member of %s command chain", $command->getName(), $command->getParent()));
            $this->followers[$command->getParent()][] = $command->getName();
        } else {
            $this->logger->info(sprintf("%s is a master command of a command chain that has registered member commands", $command->getName()));
        }
    }

    /**
     * The method returns list of followed command sorted by priority
     * @return Command[]
     */
    public function getFollowedCommandsByInitiator(string $commandName): array
    {
        $followedCommandsList = [];
        $followers = $this->followers[$commandName]??[];
        foreach ($followers as $follower) {
            $followedCommandsList[] = $this->commands[$follower];
        }
        return $followedCommandsList;
    }
}