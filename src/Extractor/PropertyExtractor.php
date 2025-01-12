<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\Element;
use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Property\ImageProperty;
use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;
use function array_map;
use function array_values;
use function iterator_to_array;

final readonly class PropertyExtractor implements PropertyExtractorInterface
{
    private HTMLDocument $document;

    private function __construct(string $content)
    {
        $this->document = @HTMLDocument::createFromString($content);
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    public function type(): TypeProperty
    {
        $value = $this->getValueByProperty(TypeProperty::getName());

        if (empty($value)) {
            return TypeProperty::website();
        }

        return TypeProperty::fromString($value);
    }

    public function url(): UrlProperty
    {
        $value = $this->getValueByProperty(UrlProperty::getName());

        if (empty($value)) {
            return UrlProperty::empty();
        }

        return UrlProperty::fromString($value);
    }

    public function title(): TitleProperty
    {
        $value = $this->getValueByProperty(TitleProperty::getName());

        if (empty($value)) {
            return TitleProperty::empty();
        }

        return TitleProperty::fromString($value);
    }

    /**
     * @return ImagePropertyCollection<ImageProperty>
     */
    public function images(): ImagePropertyCollection
    {
        $properties = $this->byPropertyName(ImageProperty::getName());

        return new ImagePropertyCollection(
            array_values(
                array_map(
                    static fn(string $value): ImageProperty => ImageProperty::fromUrlString($value),
                    $properties
                )
            )
        );
    }


    private function getValueByProperty(string $property): string
    {
        $properties = $this->byPropertyName($property);

        return (string) current($properties);
    }

    /**
     * @return string[]
     */
    private function byPropertyName(string $property): array
    {
        $query = sprintf('meta[property="%s"]', $property);
        $elements = $this->document->querySelectorAll($query);

        return array_map(
            static fn (Element $element) => (string) $element->getAttribute('content'),
            iterator_to_array($elements),
        );
    }
}
