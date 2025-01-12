<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class ImageProperty extends AbstractProperty
{
    public UrlProperty $url;

    private function __construct(UrlProperty $url)
    {
        $this->url = $url;
    }

    public static function fromUrlString(string $url): self
    {
        return new self(
            UrlProperty::fromString($url)
        );
    }

    public static function getName(): string
    {
        return 'og:image';
    }
}
