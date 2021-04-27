<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Builder\FakeCommand;
use App\Tests\Builder\FollowerCommand;
use App\Tests\Builder\InitiatorCommand;
use Ivmak\ChainCommandBundle\Model\ChainCommandInterface;
use Ivmak\ChainCommandBundle\Service\ChainCommandManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ChainCommandTest extends KernelTestCase
{
    private Application $application;
    private OutputInterface $output;
    private InitiatorCommand $initiatorCommand;
    private FollowerCommand $followerCommand;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->application = new Application(self::$kernel);
        $this->application->setAutoExit(false);

        $this->initiatorCommand = new InitiatorCommand();
        $this->followerCommand = new FollowerCommand();
        $this->application->add($this->initiatorCommand);
        $this->application->add($this->followerCommand);
        $this->output = new BufferedOutput();
    }

    public function testRunInitiator()
    {
        $container = self::$container;
        $manager = $container->get(ChainCommandManager::class);
        $manager->registerCommand($this->initiatorCommand);
        $manager->registerCommand($this->followerCommand);

        $code = $this->application->run(new ArrayInput([$this->initiatorCommand->getName()]), $this->output);
        $this->assertEquals(0, $code);
        $this->assertEquals($this->output->fetch(), "Test initiator\nTest follower\n");
    }

    public function testRunFollower()
    {
        $code = $this->application->run(new ArrayInput([$this->followerCommand->getName()]), $this->output);
        $this->assertEquals(113, $code);
        $this->assertEquals($this->output->fetch(), "Error: test:follower command is a member of test:initiator command chain and cannot be executed on its own.\n");
    }
}