<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Throwable;

final class OutputBuffer
{
    private int $initialLevel;

    public function start(): void
    {
        $this->initialLevel = ob_get_level();
        ob_start();
    }

    /**
     * Cleans and returns the current output buffer contents.
     *
     * @throws ViewException If no buffer level was active.
     */
    public function clean(): string
    {
        if (ob_get_level() <= $this->initialLevel) {
            throw new ViewException('Output buffer level mismatch during clean operation.');
        }

        $content = ob_get_clean();

        return $content !== false ? $content : '';
    }

    /**
     * Ensures any open buffer started by this instance is discarded safely on failure.
     */
    public function handleException(Throwable $e): void
    {
        while (ob_get_level() > $this->initialLevel) {
            ob_end_clean();
        }
    }

    /**
     * Executes a callback within an isolated buffer scope.
     *
     * @param callable(): void $callback
     * @throws ViewException
     */
    public function capture(callable $callback): string
    {
        $this->start();

        try {
            $callback();
            return $this->clean();
        } catch (Throwable $e) {
            $this->handleException($e);
            throw new ViewException(
                sprintf('Failed to capture output buffer: %s', $e->getMessage()),
                (int) $e->getCode(),
                $e
            );
        }
    }
}