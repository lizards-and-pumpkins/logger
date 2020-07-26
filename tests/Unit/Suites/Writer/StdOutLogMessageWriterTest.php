<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging\Writer;

use LizardsAndPumpkins\Logging\LogMessage;
use LizardsAndPumpkins\Logging\LogMessageWriter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Logging\Writer\StdOutLogMessageWriter
 */
class StdOutLogMessageWriterTest extends TestCase
{
    /**
     * @var StdOutLogMessageWriter
     */
    private $writer;

    final protected function setUp(): void
    {
        $this->writer = new StdOutLogMessageWriter();
    }

    public function testItIsALogMessageWriter(): void
    {
        $this->assertInstanceOf(LogMessageWriter::class, $this->writer);
    }

    public function testItOutputsTheLogMessage(): void
    {
        /** @var LogMessage| $stubMessage */
        $testMessageString = 'The log message';
        $stubMessage = $this->createMock(LogMessage::class);
        $stubMessage->method('__toString')->willReturn($testMessageString);
        
        ob_start();
        $this->writer->write($stubMessage);
        $actual = ob_get_contents();
        ob_end_clean();
        
        $this->assertSame(get_class($stubMessage) . ":\t" . $testMessageString . "\n", $actual);
    }
}
