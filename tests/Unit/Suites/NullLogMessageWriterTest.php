<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Logging\NullLogMessageWriter
 */
class NullLogMessageWriterTest extends TestCase
{
    /**
     * @var NullLogMessageWriter
     */
    private $writer;

    final protected function setUp(): void
    {
        $this->writer = new NullLogMessageWriter();
    }

    public function testItIsALogMessageWriter(): void
    {
        $this->assertInstanceOf(LogMessageWriter::class, $this->writer);
    }

    public function testItTakesALogMessage(): void
    {
        /** @var LogMessage|MockObject $mockLogMessage */
        $mockLogMessage = $this->createMock(LogMessage::class);
        $mockLogMessage->expects($this->never())->method('__toString');

        $this->writer->write($mockLogMessage);
    }
}
