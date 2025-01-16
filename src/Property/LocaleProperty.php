<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class LocaleProperty extends AbstractProperty
{
    private const string DEFAULT_LOCALE = 'en_US';

    /**
     * @var LocaleProperty[]
     */
    public array $alternates;

    /**
     * @param LocaleProperty[] $alternates
     */
    public function __construct(string $content, array $alternates)
    {
        $this->alternates = $alternates;

        parent::__construct($content);
    }


    public static function getName(): string
    {
        return 'og:locale';
    }

    /**
     * @param LocaleProperty[] $alternates
     */
    public static function new(string $content, array $alternates = []): LocaleProperty
    {
        return new self($content, $alternates);
    }
}
