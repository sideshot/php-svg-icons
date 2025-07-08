# PHP SVG Icons

A simple PHP package for using Lucide SVG icons with easy attribute injection, styling, and accessibility.

> **Note:** This package is focused on the [Lucide](https://lucide.dev/) icon set. If you want to support other SVG icon sets, you can replicate the pattern in your own class or extend this one.

## Installation

```bash
composer require sideshot/php-svg-icons
```

## Package Size

- Includes **~1300+ Lucide SVG icons**
- Approximate disk usage after install: **2–3MB**
- All icons are stored locally in the package for fast, offline access

## Usage

```php
use Sideshot\PhpSvgIcons\Icon;

$icon = new Icon();

// Basic usage
echo $icon->lucide('arrow-up');

// With CSS classes
echo $icon->lucide('heart', 'w-6 h-6 text-red-500');

// With custom attributes
echo $icon->lucide('star', 'w-5 h-5', attributes: [
    'stroke-width' => '2',
    'fill' => 'currentColor'
]);

// With accessible label (auto-sets role, aria-label, aria-hidden)
echo $icon->lucide('plus', 'w-4 h-4', label: 'Add item');

// Named arguments for clarity
echo $icon->lucide(
    name: 'check-circle',
    classes: 'w-5 h-5 text-green-500',
    label: 'Success'
);
```

## Features

- **Automatic download**: Lucide icons are automatically downloaded during package installation
- **Flexible attributes**: Add any SVG attributes (stroke-width, fill, etc.)
- **CSS classes**: Easy styling with Tailwind or custom classes
- **Accessibility**: Use the `label` parameter for accessible icons, or default to decorative
- **Error handling**: Returns empty string if icon doesn't exist
- **Extensible**: You can add support for other SVG icon sets by replicating the class/method pattern for your own needs

## Accessibility Guidelines

### The `label` Parameter
- If you provide `label`, the icon will have `role="img"`, `aria-label`, and `aria-hidden="false"` automatically set (unless you override them in `attributes`).
- If you do **not** provide `label`, the icon will default to `aria-hidden="true"` (decorative, hidden from assistive tech).
- You can always override any ARIA attribute by passing it in `attributes`.

### When to Use `label`
- Use `label` when the icon conveys meaning not present in surrounding text (e.g., a standalone plus icon for "Add item").
- Do **not** use `label` if the icon is purely decorative or the meaning is clear from adjacent text (e.g., an icon next to "Buy Now").

### Examples

```php
// Decorative icon (default - hidden from screen readers)
echo $icon->lucide('arrow-right', 'w-4 h-4');

// Informative icon (announced as "Add item")
echo $icon->lucide('plus', 'w-4 h-4', label: 'Add item');

// Icon with text (icon is decorative)
echo $icon->lucide('plus', 'w-4 h-4', ['aria-hidden' => 'true']);
echo 'Add item';

// Override ARIA attributes manually
echo $icon->lucide('info', 'w-4 h-4', attributes: [
    'aria-label' => 'Information',
    'role' => 'img',
    'aria-hidden' => 'false'
]);
```

### Best Practices
- **Be descriptive**: Use `label` to provide context when needed
- **Keep it concise**: Avoid redundant text
- **Test with screen readers**: Ensure your ARIA labels make sense

## Available Icons

All [Lucide icons](https://lucide.dev/icons/) are available. Just use the icon name:

- `arrow-up`
- `heart`
- `star`
- `home`
- `user`
- And 1300+ more...

## License

MIT License - see [LICENSE](LICENSE) file for details. 