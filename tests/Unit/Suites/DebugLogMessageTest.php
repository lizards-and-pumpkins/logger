<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging;

use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Logging\DebugLogMessage
 */
class DebugLogMessageTest extends TestCase
{
    public function testItIsALogMessage(): void
    {
        $this->assertInstanceOf(LogMessage::class, new DebugLogMessage('Test Message'));
    }

    public function testItReturnsTheLogMessage(): void
    {
        $this->assertSame('Test Message', (string) new DebugLogMessage('Test Message'));
    }

    public function testItReturnsTheGivenContext(): void
    {
        $context = ['foo' => 'bar'];

        $this->assertSame($context, (new DebugLogMessage('Foo', $context))->getContext());
    }

    public function testItReturnsTheContextInStringFormat(): void
    {
        $context = [
            'a string' => 'foo',
            'an int' => 123,
            'nothing' => null,
            'an object' => $this,
        ];
        $expected = preg_replace('#\s{2,}#', ' ', str_replace("\n", ' ', print_r([
            'a string' => 'foo',
            'an int' => 123,
            'nothing' => null,
            'an object' => get_class($this),
        ], true)));

        $this->assertSame($expected, (new DebugLogMessage('Test Message', $context))->getContextSynopsis());
    }
}
