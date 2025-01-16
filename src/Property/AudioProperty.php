<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class AudioProperty extends AbstractProperty
{
    public AudioSecureUrlProperty $secureUrl;
    public AudioTypeProperty $type;

    private function __construct(string $content, AudioSecureUrlProperty $secureUrl, AudioTypeProperty $type)
    {
        $this->secureUrl = $secureUrl;
        $this->type = $type;

        parent::__construct($content);
    }

    public static function new(string $content, AudioSecureUrlProperty $secureUrl, AudioTypeProperty $type): self
    {
        return new self(
            $content,
            $secureUrl,
            $type
        );
    }

    public static function fromString(string $content): static
    {
        return new self(
            content: $content,
            secureUrl: AudioSecureUrlProperty::empty(),
            type: AudioTypeProperty::empty()
        );
    }

    public static function empty(): static
    {
        return self::fromString('');
    }


    public static function getName(): string
    {
        return 'og:audio';
    }
}
