<?php

namespace Sideshot\PhpSvgIcons;

/**
 * Icon helper for Lucide SVG icons.
 */
class Icon
{
    private string $basePath;

    public function __construct()
    {
        $this->basePath = rtrim(__DIR__ . '/icons/', '/') . '/';
    }

    /**
     * Render a Lucide SVG icon.
     *
     * @param string $name      Icon name (without extension)
     * @param string $classes   CSS classes for the <svg> element
     * @param array  $attributes Additional SVG attributes (associative array)
     * @param string|null $label Accessible label. If set, auto-sets role, aria-label, and aria-hidden.
     * @return string SVG markup or empty string if not found
     */
    public function lucide(string $name, string $classes = '', array $attributes = [], ?string $label = null): string
    {
        $file = $this->basePath . 'lucide/' . $name . '.svg';
        if (!file_exists($file)) {
            return '';
        }

        $svg = file_get_contents($file);

        // Accessibility: auto-set ARIA if label is provided
        if ($label !== null) {
            if (!array_key_exists('aria-label', $attributes)) {
                $attributes['aria-label'] = $label;
            }
            if (!array_key_exists('aria-hidden', $attributes)) {
                $attributes['aria-hidden'] = 'false';
            }
            if (!array_key_exists('role', $attributes)) {
                $attributes['role'] = 'img';
            }
        } else {
            if (!array_key_exists('aria-hidden', $attributes)) {
                $attributes['aria-hidden'] = 'true';
            }
        }

        // Escape all attribute values
        foreach ($attributes as $attr => $value) {
            $escapedAttr = htmlspecialchars($attr, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $escapedValue = htmlspecialchars((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // Replace or add attribute
            $svg = preg_replace(
                "/(<svg\b[^>]*?)\b$escapedAttr=['\"]?[^'\"]*['\"]?/i",
                "$1 $escapedAttr=\"$escapedValue\"",
                $svg,
                1
            );
            if (!preg_match("/\b$escapedAttr=['\"]/i", $svg)) {
                $svg = str_replace('<svg', "<svg $escapedAttr=\"$escapedValue\"", $svg);
            }
        }

        // Add classes (escaped)
        $escapedClasses = htmlspecialchars($classes, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $svg = preg_replace('/<svg(\s|>)/', "<svg class=\"$escapedClasses\"$1", $svg, 1);

        return $svg;
    }
}