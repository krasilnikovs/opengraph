<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageProperty extends AbstractProperty
{
    public ImageSecureUrlProperty $secureUrl;
    public ImageTypeProperty $type;
    public ImageWidthProperty $width;
    public ImageHeightProperty $height;
    public ImageAltProperty $alt;

    private function __construct(string $content, ImageSecureUrlProperty $secureUrl, ImageTypeProperty $type, ImageWidthProperty $width, ImageHeightProperty $height, ImageAltProperty $alt)
    {
        $this->secureUrl = $secureUrl;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->alt = $alt;

        parent::__construct($content);
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

    public static function getIdentifiers(): array
    {
        return ['og:image'];
    }
}
