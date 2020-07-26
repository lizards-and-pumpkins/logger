<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Logging;

interface Logger
{
    public function log(LogMessage $message): void;

    /**
     * @return LogMessage[]
     */
    public function getMessages(): array;
}
