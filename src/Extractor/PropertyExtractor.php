<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\Element;
use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Model\Property\ImageProperty;
use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\TitleProperty;
use Krasilnikovs\Opengraph\Model\Property\TypeProperty;
use Krasilnikovs\Opengraph\Model\Property\UrlProperty;
use function array_map;
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
        $value = $this->getValueByProperty(TypeProperty::getIdentifier());

        if (empty($value)) {
            return TypeProperty::website();
        }

        return TypeProperty::fromString($value);
    }

    public function url(): UrlProperty
    {
        $value = $this->getValueByProperty(UrlProperty::getIdentifier());

        if (empty($value)) {
            return UrlProperty::empty();
        }

        return UrlProperty::fromString($value);
    }

    public function title(): TitleProperty
    {
        $value = $this->getValueByProperty(TitleProperty::getIdentifier());

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
        $properties = $this->getPropertiesStartsWith(ImageProperty::getIdentifier());

        $images = [];

        foreach ($properties as [$property, $content]) {
            if ($property === ImageProperty::getIdentifier()) {
                $images[] = ImageProperty::fromUrl($content);
            }
        }

        return new ImagePropertyCollection($images);
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

    /**
     * @return iterable<array{string, string}>
     */
    private function getPropertiesStartsWith(string $property): iterable
    {
        // @TODO FIX EXTRACTING META like query
        $query = sprintf('meta[property="%s"]', $property);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield [(string) $element->getAttribute('property'), (string) $element->getAttribute('content')];
        }
    }
}
