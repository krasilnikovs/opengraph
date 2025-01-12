<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Locale
{
    public const string DEFAULT_LOCALE = 'en_US';

    public string $value;
    /**
     * @var string[]
     */
    public array $alternates;

    /**
     * @param string[] $alternates
     */
    public function __construct(string $value, array $alternates)
    {
        $this->value = $value;
        $this->alternates = $alternates;
    }

    /**
     * @param string[] $alternates
     */
    public static function new(string $content, array $alternates = []): Locale
    {
        return new self($content, $alternates);
    }
}
