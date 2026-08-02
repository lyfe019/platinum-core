<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Compiles raw template strings into executable PHP view files.
 */
final class ViewCompiler
{
    /**
     * Compiles raw template contents into executable PHP code.
     */
    public function compile(string $contents): string
    {
        // Directives compilation pipeline
        $contents = $this->compileEscapedEchoes($contents);
        $contents = $this->compileRawEchoes($contents);

        return $contents;
    }

    /**
     * Compiles escaped echo directives: {{ $var }} -> <?= htmlspecialchars(...) ?>
     */
    private function compileEscapedEchoes(string $value): string
    {
        return preg_replace(
            '/\{\{\s*(.+?)\s*\}\}/s',
            '<?php echo htmlspecialchars((string) ($1), ENT_QUOTES, \'UTF-8\'); ?>',
            $value
        ) ?? $value;
    }

    /**
     * Compiles unescaped raw echo directives: {!! $var !!} -> <?= ... ?>
     */
    private function compileRawEchoes(string $value): string
    {
        return preg_replace(
            '/\{\!\!\s*(.+?)\s*\!\!\}/s',
            '<?php echo $1; ?>',
            $value
        ) ?? $value;
    }
}