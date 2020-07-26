<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging;

use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Logging\InMemoryLogger
 */
class InMemoryLoggerTest extends TestCase
{
    /**
     * @var InMemoryLogger
     */
    private $logger;

    final protected function setUp(): void
    {
        $this->logger = new InMemoryLogger();
    }

    public function testItStoresTheMessagesInOrder(): void
    {
        $stubLogMessage1 = $this->createMock(LogMessage::class);
        $stubLogMessage2 = $this->createMock(LogMessage::class);
        $stubLogMessage3 = $this->createMock(LogMessage::class);

        $this->logger->log($stubLogMessage1);
        $this->logger->log($stubLogMessage2);
        $this->logger->log($stubLogMessage3);

        $this->assertSame([
            $stubLogMessage1,
            $stubLogMessage2,
            $stubLogMessage3
        ], $this->logger->getMessages());
    }

    public function testItOnlyKeepsA500MessagesRollingWindow(): void
    {
        $stubLogMessage1 = $this->createMock(LogMessage::class);
        $stubLogMessage2 = $this->createMock(LogMessage::class);
        $otherLogMessage = $this->createMock(LogMessage::class);

        $this->logger->log($stubLogMessage1);
        $this->logger->log($stubLogMessage2);

        for ($i = 0; $i < 498; $i ++) {
            $this->logger->log($otherLogMessage);
        }
        $this->assertSame($stubLogMessage1, $this->logger->getMessages()[0]);
        $this->assertSame($stubLogMessage2, $this->logger->getMessages()[1]);

        $this->logger->log($otherLogMessage);
        $this->assertSame($stubLogMessage2, $this->logger->getMessages()[0]);
        $this->assertSame($otherLogMessage, $this->logger->getMessages()[1]);
    }
}
