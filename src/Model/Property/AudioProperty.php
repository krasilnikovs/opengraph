<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class AudioProperty extends AbstractProperty
{
    private AudioSecureUrlProperty $secureUrl;
    private AudioTypeProperty $type;

    private function __construct(string $content, AudioSecureUrlProperty $secureUrl, AudioTypeProperty $type)
    {
        $this->secureUrl = $secureUrl;
        $this->type = $type;

        parent::__construct($content);
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


    public static function getIdentifier(): string
    {
        return 'og:audio';
    }

    public function withSecureUrl(string $secureUrl): self
    {
        return $this->cloneWith(secureUrl: AudioSecureUrlProperty::fromString($secureUrl));
    }

    public function withType(string $type): self
    {
        return $this->cloneWith(type: AudioTypeProperty::fromString($type));
    }

    public function cloneWith(
        ?AudioSecureUrlProperty $secureUrl = null,
        ?AudioTypeProperty $type = null,
    ): self {
        return new self(
            content: $this->content,
            secureUrl: $secureUrl ?? clone $this->secureUrl,
            type: $type ?? clone $this->type,
        );
    }
}
