<?php

declare(strict_types=1);

namespace Ivmak\ChainCommandBundle\Event\Listener;

use Ivmak\ChainCommandBundle\Model\ChainCommandFollowerInterface;
use Ivmak\ChainCommandBundle\Model\ChainCommandInitiatorInterface;
use Ivmak\ChainCommandBundle\Service\ChainCommandManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Exception;

class CommandListener implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger, private ChainCommandManager $manager) {}

    /**
     * @param ConsoleCommandEvent $event
     * @throws Exception
     */
    public function beforeExecuting(ConsoleCommandEvent $event)
    {
        $command = $event->getCommand();
        if ($command instanceof ChainCommandInitiatorInterface) {
            $this->logger->info(sprintf("Executing  %s command itself first:", $command->getName()));
        }
        if ($command instanceof ChainCommandFollowerInterface) {
            $output = $event->getOutput();
            $output->writeln(sprintf(
                'Error: %s command is a member of %s command chain and cannot be executed on its own.',
                $command->getName(), $command->getParent()
            ));
            $event->disableCommand();
        }
    }

    /**
     * @param ConsoleTerminateEvent $event
     * @throws Exception
     */
    public function afterExecuting(ConsoleTerminateEvent $event)
    {
        $command = $event->getCommand();
        if ($command instanceof ChainCommandInitiatorInterface) {
            $followedCommands = $this->manager->getFollowedCommandsByInitiator($command->getName());
            $application = $command->getApplication();
            foreach ($followedCommands as $followedCommand) {
                $this->logger->info(sprintf("Executing %s chain members:", $command->getName()));
                $child = $application->add($followedCommand);
                $child->run($event->getInput(), $event->getOutput());
            }
            $this->logger->info(sprintf("Execution of %s chain completed.", $command->getName()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::TERMINATE => 'afterExecuting',
            ConsoleEvents::COMMAND => 'beforeExecuting'
        ];
    }
}