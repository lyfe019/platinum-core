<?php

declare(strict_types=1);

namespace Platinum\Core\Console;

/**
 * Console output stream abstraction.
 */
final class Output
{
    /** @var string[] */
    private array $buffer = [];

    public function write(string $message): void
    {
        $this->buffer[] = $message;
    }

    public function writeln(string $message): void
    {
        $this->buffer[] = $message . PHP_EOL;
    }

    public function info(string $message): void
    {
        $this->writeln('[INFO] ' . $message);
    }

    public function success(string $message): void
    {
        $this->writeln('[SUCCESS] ' . $message);
    }

    public function error(string $message): void
    {
        $this->writeln('[ERROR] ' . $message);
    }

    /**
     * @return string[]
     */
    public function buffer(): array
    {
        return $this->buffer;
    }

    public function flush(): string
    {
        $output = implode('', $this->buffer);
        $this->buffer = [];

        return $output;
    }
}