<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Property;

final readonly class MetaExtractor
{
    private HTMLDocument $document;

    private function __construct(string $content)
    {
        $this->document = HTMLDocument::createFromString($content);
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    public function type(): string
    {
        return $this->singleValueByProperty(Property::Type);
    }

    public function url(): string
    {
        return $this->singleValueByProperty(Property::Url);
    }

    public function title(): string
    {
        return $this->singleValueByProperty(Property::Title);
    }

    /**
     * @return iterable<Property\Image>
     */
    public function images(): iterable
    {
        $properties = $this->byProperty(Property::Image);

        foreach ($properties as $value) {
            yield Property\Image::fromUrlString($value);
        }
    }

    private function singleValueByProperty(Property $property): string
    {
        $properties = $this->byProperty($property);

        if (empty($properties)) {
            return '';
        }

        [$value] = $properties;

        return $value;
    }

    /**
     * @return iterable<string>
     */
    private function byProperty(Property $property): iterable
    {
        $query = sprintf('meta[property="%s"]', $property->value);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield (string) $element->getAttribute('content');
        }
    }
}
