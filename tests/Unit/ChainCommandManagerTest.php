<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Tests\Builder\FakeCommand;
use App\Tests\Builder\InitiatorCommand;
use App\Tests\Builder\FollowerCommand;
use Ivmak\ChainCommandBundle\Exception\RuntimeException;
use Ivmak\ChainCommandBundle\Service\ChainCommandManager;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ChainCommandManagerTest extends TestCase
{
    private LoggerInterface $loggerMock;
    private InitiatorCommand $initiatorCommand;
    private FollowerCommand $followerCommand;
    private FakeCommand $fakeCommand;

    /**
     * {@inheritdoc }
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loggerMock = $this->getMockBuilder(LoggerInterface::class)->getMock();
        $this->initiatorCommand = new InitiatorCommand();
        $this->followerCommand = new FollowerCommand();
        $this->fakeCommand = new FakeCommand();
    }

    public function testGetFollowedCommand(): void
    {
        $manager = new ChainCommandManager($this->loggerMock, [$this->initiatorCommand, $this->followerCommand]);
        $followedCommands = $manager->getFollowedCommandsByInitiator($this->initiatorCommand->getName());
        self::assertEquals([$this->followerCommand], $followedCommands);
    }


    public function testGetEmptyFollowedCommand(): void
    {
        $manager = new ChainCommandManager($this->loggerMock, [$this->initiatorCommand]);
        $followedCommands = $manager->getFollowedCommandsByInitiator($this->initiatorCommand->getName());
        self::assertEquals([], $followedCommands);
    }

    public function testWrongCommandRegister(): void
    {
        self::expectException(RuntimeException::class);
        self::expectExceptionMessage('Wrong class implemented as a Chain Command');

        new ChainCommandManager($this->loggerMock, [$this->fakeCommand]);
    }
}
