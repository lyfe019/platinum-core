<?php

declare(strict_types=1);

namespace Platinum\Core\View;

/**
 * Asset Manager.
 *
 * Represents the collection of assets required by
 * a rendered view.
 *
 * The AssetManager is framework-owned and completely
 * independent of any host platform.
 *
 * Host integrations (such as WordPress) translate
 * these assets into platform-specific registrations.
 *
 * The object is immutable.
 */
final class AssetManager
{
    /**
     * Stylesheets.
     *
     * @var array<int, string>
     */
    private array $styles;

    /**
     * JavaScript files.
     *
     * @var array<int, string>
     */
    private array $scripts;

    /**
     * Module scripts.
     *
     * @var array<int, string>
     */
    private array $modules;

    /**
     * Preloaded assets.
     *
     * @var array<int, string>
     */
    private array $preloads;

    /**
     * Deferred scripts.
     *
     * @var array<int, string>
     */
    private array $deferred;

    /**
     * Inline JavaScript.
     *
     * @var array<int, string>
     */
    private array $inlineScripts;

    /**
     * Inline CSS.
     *
     * @var array<int, string>
     */
    private array $inlineStyles;

    /**
     * Create a new asset collection.
     *
     * @param array<int,string> $styles
     * @param array<int,string> $scripts
     * @param array<int,string> $modules
     * @param array<int,string> $preloads
     * @param array<int,string> $deferred
     * @param array<int,string> $inlineScripts
     * @param array<int,string> $inlineStyles
     */
    public function __construct(
        array $styles = [],
        array $scripts = [],
        array $modules = [],
        array $preloads = [],
        array $deferred = [],
        array $inlineScripts = [],
        array $inlineStyles = [],
    ) {
        $this->styles = $styles;
        $this->scripts = $scripts;
        $this->modules = $modules;
        $this->preloads = $preloads;
        $this->deferred = $deferred;
        $this->inlineScripts = $inlineScripts;
        $this->inlineStyles = $inlineStyles;
    }

    /**
     * Return stylesheets.
     *
     * @return array<int,string>
     */
    public function styles(): array
    {
        return $this->styles;
    }

    /**
     * Return JavaScript files.
     *
     * @return array<int,string>
     */
    public function scripts(): array
    {
        return $this->scripts;
    }

    /**
     * Return module scripts.
     *
     * @return array<int,string>
     */
    public function modules(): array
    {
        return $this->modules;
    }

    /**
     * Return preload assets.
     *
     * @return array<int,string>
     */
    public function preloads(): array
    {
        return $this->preloads;
    }

    /**
     * Return deferred scripts.
     *
     * @return array<int,string>
     */
    public function deferred(): array
    {
        return $this->deferred;
    }

    /**
     * Return inline JavaScript.
     *
     * @return array<int,string>
     */
    public function inlineScripts(): array
    {
        return $this->inlineScripts;
    }

    /**
     * Return inline styles.
     *
     * @return array<int,string>
     */
    public function inlineStyles(): array
    {
        return $this->inlineStyles;
    }

    /**
     * Determine whether the page has assets.
     */
    public function isEmpty(): bool
    {
        return
            $this->styles === [] &&
            $this->scripts === [] &&
            $this->modules === [] &&
            $this->preloads === [] &&
            $this->deferred === [] &&
            $this->inlineScripts === [] &&
            $this->inlineStyles === [];
    }
}