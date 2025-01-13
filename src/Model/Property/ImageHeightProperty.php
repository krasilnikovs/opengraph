<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageHeightProperty extends AbstractProperty
{
    public string $content;

    private function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    public static function empty(): self
    {
        return self::fromString('');
    }

    public static function getIdentifiers(): array
    {
        return ['og:image:height'];
    }
}
