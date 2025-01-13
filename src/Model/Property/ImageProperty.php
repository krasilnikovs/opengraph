<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

final readonly class ImageProperty extends AbstractProperty
{
    public ImageUrlProperty $url;
    public ImageSecureUrlProperty $secureUrl;
    public ImageTypeProperty $type;
    public ImageWidthProperty $width;
    public ImageHeightProperty $height;
    public ImageAltProperty $alt;

    private function __construct(ImageUrlProperty $url, ImageSecureUrlProperty $secureUrl, ImageTypeProperty $type, ImageWidthProperty $width, ImageHeightProperty $height, ImageAltProperty $alt)
    {
        $this->url = $url;
        $this->secureUrl = $secureUrl;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->alt = $alt;
    }

    public static function default(): self
    {
        return new self(
            url: ImageUrlProperty::empty(),
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

    public static function fromUrl(string $url): self
    {
        return new self(
            url: ImageUrlProperty::fromString($url),
            secureUrl: ImageSecureUrlProperty::empty(),
            type: ImageTypeProperty::empty(),
            width: ImageWidthProperty::empty(),
            height: ImageHeightProperty::empty(),
            alt: ImageAltProperty::empty(),
        );
    }
}
