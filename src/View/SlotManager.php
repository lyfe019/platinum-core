<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Manages named slot regions for view components and layouts.
 */
final class SlotManager
{
    /** @var array<string, string> */
    private array $slots = [];
    /** @var string[] */
    private array $activeSlotStack = [];

    /**
     * Set explicit content for a named slot.
     */
    public function set(string $name, string $content): void
    {
        $this->slots[$name] = $content;
    }

    /**
     * Append content to an existing named slot.
     */
    public function append(string $name, string $content): void
    {
        $this->slots[$name] = ($this->slots[$name] ?? '') . $content;
    }

    /**
     * Retrieve content of a named slot with optional default fallback.
     */
    public function get(string $name, string $default = ''): string
    {
        return $this->slots[$name] ?? $default;
    }

    /**
     * Check if a named slot has non-empty content.
     */
    public function has(string $name): bool
    {
        return isset($this->slots[$name]) && trim($this->slots[$name]) !== '';
    }

    /**
     * Start capturing output buffer content into a named slot.
     */
    public function start(string $name): void
    {
        $this->activeSlotStack[] = $name;
        ob_start();
    }

    /**
     * End output buffer capture and assign content to the current slot.
     */
    public function end(): void
    {
        if (empty($this->activeSlotStack)) {
            return;
        }

        $name = array_pop($this->activeSlotStack);
        $content = ob_get_clean();

        if ($content !== false) {
            $this->set($name, $content);
        }
    }
}