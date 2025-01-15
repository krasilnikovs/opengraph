<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageProperty extends AbstractProperty
{
    public ImageSecureUrlProperty $secureUrl;
    public ImageTypeProperty $type;
    public ImageWidthProperty $width;
    public ImageHeightProperty $height;
    public ImageAltProperty $alt;

    private function __construct(
        string $content,
        ImageSecureUrlProperty $secureUrl,
        ImageTypeProperty $type,
        ImageWidthProperty $width,
        ImageHeightProperty $height,
        ImageAltProperty $alt
    ) {
        $this->secureUrl = $secureUrl;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->alt = $alt;

        parent::__construct($content);
    }

    public static function new(
        string $content,
        ImageSecureUrlProperty $secureUrl,
        ImageTypeProperty $type,
        ImageWidthProperty $width,
        ImageHeightProperty $height,
        ImageAltProperty $alt
    ): self
    {
        return new self($content, $secureUrl, $type, $width, $height, $alt);
    }

    public static function fromString(string $content): static
    {
        return new self(
            content: $content,
            secureUrl: ImageSecureUrlProperty::empty(),
            type: ImageTypeProperty::empty(),
            width: ImageWidthProperty::empty(),
            height: ImageHeightProperty::empty(),
            alt: ImageAltProperty::empty(),
        );
    }

    public static function empty(): static
    {
        return new self(
            content: '',
            secureUrl: ImageSecureUrlProperty::empty(),
            type: ImageTypeProperty::empty(),
            width: ImageWidthProperty::empty(),
            height: ImageHeightProperty::empty(),
            alt: ImageAltProperty::empty(),
        );
    }

    public static function getIdentifier(): string
    {
        return 'og:image';
    }
    public function withSecureUrl(string $secureUrl): self
    {
        return $this->cloneWith(secureUrl: ImageSecureUrlProperty::fromString($secureUrl));
    }

    public function withType(string $type): self
    {
        return $this->cloneWith(type: ImageTypeProperty::fromString($type));
    }

    public function withWidth(string $width): self
    {
        return $this->cloneWith(width: ImageWidthProperty::fromString($width));
    }

    public function withHeight(string $height): self
    {
        return $this->cloneWith(height: ImageHeightProperty::fromString($height));
    }

    public function withAlt(ImageAltProperty $alt): self
    {
        return $this->cloneWith(alt: $alt);
    }

    private function cloneWith(
        ?ImageSecureUrlProperty $secureUrl = null,
        ?ImageTypeProperty $type = null,
        ?ImageWidthProperty $width = null,
        ?ImageHeightProperty $height = null,
        ?ImageAltProperty $alt = null
    ): self {
        return new self(
            content:   $this->content,
            secureUrl: $secureUrl      ?? clone $this->secureUrl,
            type:      $type           ?? clone $this->type,
            width:     $width          ?? clone $this->width,
            height:    $height         ?? clone $this->height,
            alt:       $alt            ?? clone $this->alt,
        );
    }
}
