<?php

declare(strict_types=1);

namespace Platinum\Core\View\Bridges;

use Platinum\Core\View\ViewFacade;

/**
 * Encapsulates view rendering into HTTP response payloads.
 */
final class ViewResponseFactory
{
    private ViewFacade $viewFacade;

    public function __construct(ViewFacade $viewFacade)
    {
        $this->viewFacade = $viewFacade;
    }

    /**
     * Render view template and output directly to the HTTP response stream.
     *
     * @param array<string, mixed> $data
     */
    public function renderToResponse(string $template, array $data = [], int $statusCode = 200, array $headers = []): void
    {
        $html = $this->viewFacade->make($template, $data);

        http_response_code($statusCode);
        
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=UTF-8');
            foreach ($headers as $name => $value) {
                header(sprintf('%s: %s', $name, $value));
            }
        }

        echo $html;
    }
}