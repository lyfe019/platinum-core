=<?php

declare(strict_types=1);

namespace Platinum\Core\View;

use Throwable;

final class TemplateEngine
{
    private VariableExtractorInterface $variableExtractor;
    private OutputBuffer $buffer;

    public function __construct(
        ?VariableExtractorInterface $variableExtractor = null,
        ?OutputBuffer $buffer = null
    ) {
        $this->variableExtractor = $variableExtractor ?? new VariableExtractor();
        $this->buffer = $buffer ?? new OutputBuffer();
    }

    /**
     * Evaluates a template file with extracted data and context variables.
     *
     * @throws ViewException
     */
    public function renderFile(string $filePath, ViewData $data, ViewContext $context): string
    {
        if (!file_exists($filePath)) {
            throw new ViewException(sprintf('Template file not found at path [%s].', $filePath));
        }

        $extractedVariables = $this->variableExtractor->extract($data, $context);

        return $this->buffer->capture(function () use ($filePath, $extractedVariables): void {
            // Isolates variable extraction to this closure's scope
            (static function (string $file, array $__variables): void {
                extract($__variables, EXTR_SKIP);
                require $file;
            })($filePath, $extractedVariables);
        });
    }
}