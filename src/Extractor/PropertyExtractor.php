<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\Element;
use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Model\Property\AudioProperty;
use Krasilnikovs\Opengraph\Model\Property\AudioPropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\AudioSecureUrlProperty;
use Krasilnikovs\Opengraph\Model\Property\AudioTypeProperty;
use Krasilnikovs\Opengraph\Model\Property\Builder\AudioPropertyCollectionBuilder;
use Krasilnikovs\Opengraph\Model\Property\Builder\ImagePropertyCollectionBuilder;
use Krasilnikovs\Opengraph\Model\Property\ImageAltProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageHeightProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageProperty;
use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\ImageSecureUrlProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageTypeProperty;
use Krasilnikovs\Opengraph\Model\Property\ImageWidthProperty;
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

        return TypeProperty::fromString($value);
    }

    public function url(): UrlProperty
    {
        $value = $this->getValueByProperty(UrlProperty::getIdentifier());

        return UrlProperty::fromString($value);
    }

    public function title(): TitleProperty
    {
        $value = $this->getValueByProperty(TitleProperty::getIdentifier());

        return TitleProperty::fromString($value);
    }

    /**
     * @return ImagePropertyCollection<ImageProperty>
     */
    public function images(): ImagePropertyCollection
    {
        $properties = $this->getPropertiesWithPrefix(ImageProperty::getIdentifier());

        $builder = ImagePropertyCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {
            $builder = match ($property) {
                ImageProperty::getIdentifier()          =>  $builder->withUrl($content),
                ImageSecureUrlProperty::getIdentifier() =>  $builder->withSecureUrl($content),
                ImageTypeProperty::getIdentifier()      =>  $builder->withType($content),
                ImageWidthProperty::getIdentifier()     =>  $builder->withWidth($content),
                ImageHeightProperty::getIdentifier()    =>  $builder->withHeight($content),
                ImageAltProperty::getIdentifier()       =>  $builder->withAlt($content),
                default => $builder,
            };
        }

        return $builder->build();
    }

    /**
     * @return AudioPropertyCollection<AudioProperty>
     */
    public function audios(): AudioPropertyCollection
    {
        $properties = $this->getPropertiesWithPrefix(AudioProperty::getIdentifier());

        $builder = AudioPropertyCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {
            $builder = match ($property) {
                AudioProperty::getIdentifier()          => $builder->withUrl($content),
                AudioSecureUrlProperty::getIdentifier() => $builder->withSecureUrl($content),
                AudioTypeProperty::getIdentifier()      => $builder->withType($content),
                default                                 => $builder,
            };
        }

        return $builder->build();
    }


    private function getValueByProperty(string $property): string
    {
        $properties = $this->getPropertiesWithName($property);

        return (string) current($properties);
    }

    /**
     * @return string[]
     */
    private function getPropertiesWithName(string $name): array
    {
        $query = sprintf('meta[property="%s"]', $name);
        $elements = $this->document->querySelectorAll($query);

        return array_map(
            static fn (Element $element) => (string) $element->getAttribute('content'),
            iterator_to_array($elements),
        );
    }

    /**
     * @return iterable<array{string, string}>
     */
    private function getPropertiesWithPrefix(string $prefix): iterable
    {
        $query = sprintf('meta[property^="%s"]', $prefix);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield [(string) $element->getAttribute('property'), (string) $element->getAttribute('content')];
        }
    }
}
