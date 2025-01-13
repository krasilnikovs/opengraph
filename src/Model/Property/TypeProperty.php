<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class TypeProperty extends AbstractProperty
{
    private const string WEBSITE = 'website';

    public string $content;

    private function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    public static function website(): self
    {
        return self::fromString(self::WEBSITE);
    }

    public static function getIdentifiers(): array
    {
        return ['og:type'];
    }

    public function isWebsite(): bool
    {
        return $this->content === self::WEBSITE;
    }
}
