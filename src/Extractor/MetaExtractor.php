<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\Element;
use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Property\ImageProperty;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;

final readonly class MetaExtractor implements MetaExtractorInterface
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

    public function type(): string
    {
        return $this->singleValueByProperty(TypeProperty::getName());
    }

    public function url(): string
    {
        return $this->singleValueByProperty(UrlProperty::getName());
    }

    public function title(): string
    {
        return $this->singleValueByProperty(TitleProperty::getName());
    }

    /**
     * @return ImageProperty[]
     */
    public function images(): array
    {
        $properties = $this->byPropertyName(ImageProperty::getName());

        return array_map(
            static fn(string $value): ImageProperty => ImageProperty::fromUrlString($value),
            $properties
        );
    }

    private function singleValueByProperty(string $property): string
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
