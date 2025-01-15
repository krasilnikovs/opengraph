<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property\Builder;

use Krasilnikovs\Opengraph\Model\Property\ImageAltProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageHeightProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageProperty;
use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\ImageSecureUrlProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageTypeProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageWidthProperty;

final readonly class ImagePropertyCollectionBuilder
{
    /**
     * @var array<int, array{
     *      url?: string,
     *      secureUrl?: string,
     *      type?: string,
     *      width?: string,
     *      height?: string,
     *      alt?: string,
     * }>
     */
    private array $elements;

    /**
     * @param  array<int, array{
     *       url?: string,
     *       secureUrl?: string,
     *       type?: string,
     *       width?: string,
     *       height?: string,
     *       alt?: string,
     * }> $elements
     */
    private function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public static function new(): self
    {
        return new self([]);
    }

    public function withUrl(string $url): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['url'] = $url;

        return new self($elements);
    }

    public function withSecureUrl(string $secureUrl): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['secureUrl'] = $secureUrl;

        return new self($elements);
    }

    public function withType(string $type): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['type'] = $type;

        return new self($elements);
    }

    public function withWidth(string $width): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['width'] = $width;

        return new self($elements);
    }

    public function withHeight(string $height): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['height'] = $height;

        return new self($elements);
    }

    public function withAlt(string $alt): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['alt'] = $alt;

        return new self($elements);
    }

    public function build(): ImagePropertyCollection
    {
        $images = array_map(
            static fn(array $element): ImageProperty => ImageProperty::new(
                content: $element['url'] ?? '',
                secureUrl: ImageSecureUrlProperty::fromString($element['secureUrl'] ?? ''),
                type: ImageTypeProperty::fromString($element['type'] ?? ''),
                width: ImageWidthProperty::fromString($element['width'] ?? ''),
                height: ImageHeightProperty::fromString($element['height'] ?? ''),
                alt: ImageAltProperty::fromString($element['alt'] ?? ''),
            ),
            $this->elements,
        );

        return new ImagePropertyCollection($images);
    }
}
