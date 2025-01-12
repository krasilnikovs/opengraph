<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Image
{
    public Url $url;

    private function __construct(Url $url)
    {
        $this->url = $url;
    }

    public static function fromUrlString(string $url): self
    {
        return new self(
            Url::fromString($url)
        );
    }
}
