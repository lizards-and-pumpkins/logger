<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging\Writer;

use LizardsAndPumpkins\Logging\LogMessage;
use LizardsAndPumpkins\Logging\LogMessageWriter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Logging\Writer\CompositeLogMessageWriter
 */
class CompositeLogMessageWriterTest extends TestCase
{
    /**
     * @var CompositeLogMessageWriter
     */
    private $writer;

    final protected function setUp(): void
    {
        $this->writer = new CompositeLogMessageWriter();
    }

    public function testItIsALogMessageWriter(): void
    {
        $this->assertInstanceOf(LogMessageWriter::class, $this->writer);
        $this->assertInstanceOf(LogMessageWriter::class, new CompositeLogMessageWriter());
    }

    public function testItDelegatesToLogMessageWriterComponents(): void
    {
        /** @var LogMessage $stubLogMessage */
        $stubLogMessage = $this->createMock(LogMessage::class);
        
        $mockWriterA = $this->createMock(LogMessageWriter::class);
        $mockWriterA->expects($this->once())->method('write')->with($stubLogMessage);
        
        $mockWriterB = $this->createMock(LogMessageWriter::class);
        $mockWriterB->expects($this->once())->method('write')->with($stubLogMessage);

        $composite = new CompositeLogMessageWriter($mockWriterA, $mockWriterB);
        $composite->write($stubLogMessage);
    }
}
