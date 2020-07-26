<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Logging\WritingLoggerDecorator
 */
class WritingLoggerDecoratorTest extends TestCase
{
    private $stubLogMessage;

    /**
     * @var WritingLoggerDecorator
     */
    private $decorator;

    /**
     * @var Logger|MockObject
     */
    private $wrappedLogger;

    /**
     * @var LogMessageWriter|MockObject
     */
    private $mockWriter;

    final protected function setUp(): void
    {
        $this->wrappedLogger = $this->createMock(Logger::class);
        $this->stubLogMessage = $this->createMock(LogMessage::class);
        $this->mockWriter = $this->createMock(LogMessageWriter::class);
        $this->decorator = new WritingLoggerDecorator($this->wrappedLogger, $this->mockWriter);
    }

    public function testItIsALogger(): void
    {
        $this->assertInstanceOf(Logger::class, $this->decorator);
    }

    public function testItDelegatesLogCallsToTheDecoratedComponent(): void
    {
        $this->wrappedLogger->expects($this->once())->method('log')->with($this->stubLogMessage);

        $this->decorator->log($this->stubLogMessage);
    }

    public function testItDelegatesGetMessagesCallsToTheDecoratedComponent(): void
    {
        $expected = [$this->stubLogMessage];
        $this->wrappedLogger->expects($this->once())->method('getMessages')->willReturn($expected);

        $this->assertSame($expected, $this->decorator->getMessages());
    }

    public function testItPassesLogMessagesToTheWriter(): void
    {
        $this->mockWriter->expects($this->once())->method('write')->with($this->stubLogMessage);
        $this->decorator->log($this->stubLogMessage);
    }
}
