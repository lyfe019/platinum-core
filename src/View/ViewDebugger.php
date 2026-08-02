<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Provides diagnostic tools and debug representations for views.
 */
final class ViewDebugger
{
    private ViewProfiler $profiler;
    private bool $enabled;

    public function __construct(ViewProfiler $profiler, bool $enabled = true)
    {
        $this->profiler = $profiler;
        $this->enabled = $enabled;
    }

    /**
     * Inspects a View instance and returns a sanitized array of debug info.
     *
     * @return array<string, mixed>
     */
    public function inspect(View $view): array
    {
        if (!$this->enabled) {
            return [];
        }

        return [
            'name' => $view->name(),
            'layout' => $view->layout(),
            'data_keys' => array_keys($view->data()->all()),
            'data_count' => count($view->data()->all()),
        ];
    }

    /**
     * Formats an HTML comments debug block to append in non-production responses.
     */
    public function dumpHtmlComment(View $view): string
    {
        if (!$this->enabled) {
            return '';
        }

        $info = $this->inspect($view);
        $totalTime = $this->profiler->totalDurationMs();

        return sprintf(
            "\n<!-- [Platinum View Debug] Name: %s | Layout: %s | Data Keys: %s | Total Render Time: %.2fms -->\n",
            $info['name'] ?? 'unknown',
            $info['layout'] ?? 'none',
            implode(', ', $info['data_keys'] ?? []),
            $totalTime
        );
    }
}