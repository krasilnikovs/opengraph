<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Type
{
    public const string WEBSITE = 'website';

    public string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function website(): self
    {
        return new self(self::WEBSITE);
    }
}
