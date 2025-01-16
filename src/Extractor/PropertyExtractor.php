<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\Element;
use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Property\AudioProperty;
use Krasilnikovs\Opengraph\Property\AudioPropertyCollection;
use Krasilnikovs\Opengraph\Property\AudioSecureUrlProperty;
use Krasilnikovs\Opengraph\Property\AudioTypeProperty;
use Krasilnikovs\Opengraph\Property\Builder\AudioPropertyCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\ImagePropertyCollectionBuilder;
use Krasilnikovs\Opengraph\Property\DescriptionProperty;
use Krasilnikovs\Opengraph\Property\DeterminerProperty;
use Krasilnikovs\Opengraph\Property\ImageAltProperty;
use Krasilnikovs\Opengraph\Property\ImageHeightProperty;
use Krasilnikovs\Opengraph\Property\ImageProperty;
use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\ImageSecureUrlProperty;
use Krasilnikovs\Opengraph\Property\ImageTypeProperty;
use Krasilnikovs\Opengraph\Property\ImageWidthProperty;
use Krasilnikovs\Opengraph\Property\LocaleAlternateProperty;
use Krasilnikovs\Opengraph\Property\LocaleProperty;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;
use function array_map;
use function iterator_to_array;

final readonly class PropertyExtractor implements PropertyExtractorInterface
{
    private const string DEFAULT_LOCALE = 'en_US';

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

        return TypeProperty::fromString($value);
    }

    public function url(): UrlProperty
    {
        $value = $this->getValueByProperty(UrlProperty::getName());

        return UrlProperty::fromString($value);
    }

    public function title(): TitleProperty
    {
        $value = $this->getValueByProperty(TitleProperty::getName());

        return TitleProperty::fromString($value);
    }

    public function description(): DescriptionProperty
    {
        $value = $this->getValueByProperty(DescriptionProperty::getName());

        return DescriptionProperty::fromString($value);
    }

    public function determiner(): DeterminerProperty
    {
        $value = $this->getValueByProperty(DeterminerProperty::getName());

        return DeterminerProperty::fromString($value);
    }

    public function locale(): LocaleProperty
    {
        $alternates = $this->getPropertiesWithName(LocaleAlternateProperty::getName());

        $alternates = array_map(
            LocaleAlternateProperty::fromString(...),
            $alternates
        );

        $locale = $this->getValueByProperty(LocaleProperty::getName());

        if (empty($locale)) {
            $locale = self::DEFAULT_LOCALE;
        }

        return LocaleProperty::new($locale, $alternates);
    }

    /**
     * @return ImagePropertyCollection<ImageProperty>
     */
    public function images(): ImagePropertyCollection
    {
        $properties = $this->getPropertiesWithPrefix(ImageProperty::getName());

        $builder = ImagePropertyCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {
            $builder = match ($property) {
                ImageProperty::getName()          =>  $builder->withUrl($content),
                ImageSecureUrlProperty::getName() =>  $builder->withSecureUrl($content),
                ImageTypeProperty::getName()      =>  $builder->withType($content),
                ImageWidthProperty::getName()     =>  $builder->withWidth($content),
                ImageHeightProperty::getName()    =>  $builder->withHeight($content),
                ImageAltProperty::getName()       =>  $builder->withAlt($content),
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
        $properties = $this->getPropertiesWithPrefix(AudioProperty::getName());

        $builder = AudioPropertyCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {
            $builder = match ($property) {
                AudioProperty::getName()          => $builder->withUrl($content),
                AudioSecureUrlProperty::getName() => $builder->withSecureUrl($content),
                AudioTypeProperty::getName()      => $builder->withType($content),
                default                           => $builder,
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
