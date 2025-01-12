<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use InvalidArgumentException;
use const FILTER_VALIDATE_URL;
use function filter_var;
use function sprintf;

final readonly class UrlProperty extends AbstractProperty
{
    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(sprintf('"%s" is not a valid URL.', $value));
        }

        return new self($value);
    }

    public static function getName(): string
    {
        return 'og:url';
    }
}
