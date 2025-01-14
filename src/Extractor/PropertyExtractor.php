<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Dom\Element;
use Dom\HTMLDocument;
use Krasilnikovs\Opengraph\Model\Property\AudioProperty;
use Krasilnikovs\Opengraph\Model\Property\AudioPropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\AudioSecureUrlProperty;
use Krasilnikovs\Opengraph\Model\Property\AudioTypeProperty;
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
                $images[] = ImageProperty::fromString($content);
                continue;
            }

            $key = array_key_last($images);

            /** @var ?ImageProperty $image */
            $image = $images[$key] ?? null;

            if ($image === null) {
                continue;
            }

            if ($property === ImageSecureUrlProperty::getIdentifier()) {
                $images[$key] = $image->withSecureUrl($content);
            }

            if ($property === ImageTypeProperty::getIdentifier()) {
                $images[$key] = $image->withType($content);
            }

            if ($property === ImageWidthProperty::getIdentifier()) {
                $images[$key] = $image->withWidth($content);
            }

            if ($property === ImageHeightProperty::getIdentifier()) {
                $images[$key] = $image->withHeight($content);
            }

            if ($property === ImageHeightProperty::getIdentifier()) {
                $images[$key] = $image->withAlt($content);
            }
        }

        return new ImagePropertyCollection($images);
    }

    /**
     * @return AudioPropertyCollection<AudioProperty>
     */
    public function audios(): AudioPropertyCollection
    {
        $properties = $this->getPropertiesStartsWith(AudioProperty::getIdentifier());

        $audios = [];

        foreach ($properties as [$property, $content]) {
            if ($property === AudioProperty::getIdentifier()) {
                $audios[] = AudioProperty::fromString($content);
                continue;
            }

            $key = array_key_last($audios);

            /** @var ?AudioProperty $audio */
            $audio = $audios[$key] ?? null;

            if ($audio === null) {
                continue;
            }

            if ($property === AudioSecureUrlProperty::getIdentifier()) {
                $audios[$key] = $audio->withSecureUrl($content);
            }

            if ($property === AudioTypeProperty::getIdentifier()) {
                $audios[$key] = $audio->withType($content);
            }
        }

        return new AudioPropertyCollection($audios);
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
        $query = sprintf('meta[property^="%s"]', $property);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield [(string) $element->getAttribute('property'), (string) $element->getAttribute('content')];
        }
    }
}
