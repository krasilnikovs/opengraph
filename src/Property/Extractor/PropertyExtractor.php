<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use Krasilnikovs\Opengraph\Property\Audio;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Builder\AudioCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\ImageCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\VideoCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\Extractor\Exception\PropertyNotExtractedException;
use Krasilnikovs\Opengraph\Property\Image;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Locale;
use Krasilnikovs\Opengraph\Property\Video;
use Krasilnikovs\Opengraph\Property\VideoCollection;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

trait PropertyExtractor
{
    final private function __construct(
        protected readonly MetaScraperInterface $scraper,
    )
    {
    }

    final public static function fromMetaScraper(MetaScraperInterface $scraper): static
    {
        return new static($scraper);
    }

    final public function type(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::TYPE_PROPERTY);
    }

    /**
     * @throws PropertyNotExtractedException
     */
    final public function url(): string
    {
        $url = $this->scraper->getContentByName(MetaScraperInterface::URL_PROPERTY);

        if ($url === '') {
            throw PropertyNotExtractedException::requiredNotEmptyValueForProperty(MetaScraperInterface::URL_PROPERTY);
        }

        return $url;
    }

    /**
     * @throws PropertyNotExtractedException
     */
    final public function title(): string
    {
        $title = $this->scraper->getContentByName(MetaScraperInterface::TITLE_PROPERTY);

        if ($title === '') {
            throw PropertyNotExtractedException::requiredNotEmptyValueForProperty(MetaScraperInterface::TITLE_PROPERTY);
        }

        return $title;
    }

    final public function description(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::DESCRIPTION_PROPERTY);
    }

    final public function siteName(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::SITE_NAME_PROPERTY);
    }

    final public function determiner(): Determiner
    {
        $value = $this->scraper->getContentByName(MetaScraperInterface::DETERMINER_PROPERTY);

        $determiner = Determiner::tryFrom($value);

        if ($determiner === null) {
            $determiner = Determiner::Empty;
        }

        return $determiner;
    }

    final public function locale(): Locale
    {
        $alternates = $this->scraper->getContentsByName(MetaScraperInterface::LOCALE_ALTERNATE_PROPERTY);

        $locale = $this->scraper->getContentByName(MetaScraperInterface::LOCALE_PROPERTY);

        if ($locale === '') {
            $locale = Locale::DEFAULT_LOCALE;
        }

        return Locale::new($locale, iterator_to_array($alternates));
    }

    /**
     * @return ImageCollection<Image>
     * @throws PropertyNotExtractedException
     */
    final public function images(): ImageCollection
    {
        $properties = $this->scraper->getContentsByPrefix(MetaScraperInterface::IMAGE_PROPERTY);

        $builder = ImageCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($content === '') {
                continue;
            }

            if ($property === MetaScraperInterface::IMAGE_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                MetaScraperInterface::IMAGE_PROPERTY => $builder->withUrl($content),
                MetaScraperInterface::IMAGE_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                MetaScraperInterface::IMAGE_TYPE_PROPERTY => $builder->withType($content),
                MetaScraperInterface::IMAGE_WIDTH_PROPERTY => $builder->withWidth($content),
                MetaScraperInterface::IMAGE_HEIGHT_PROPERTY => $builder->withHeight($content),
                MetaScraperInterface::IMAGE_ALT_PROPERTY => $builder->withAlt($content),
                default => $builder,
            };
        }

        if ($builder->isEmpty()) {
            throw PropertyNotExtractedException::atLeastOneElementRequiredForProperty(MetaScraperInterface::IMAGE_PROPERTY);
        }

        return $builder->build();
    }

    /**
     * @return AudioCollection<Audio>
     */
    final public function audios(): AudioCollection
    {
        $properties = $this->scraper->getContentsByPrefix(MetaScraperInterface::AUDIO_PROPERTY);

        $builder = AudioCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === MetaScraperInterface::AUDIO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                MetaScraperInterface::AUDIO_PROPERTY => $builder->withUrl($content),
                MetaScraperInterface::AUDIO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                MetaScraperInterface::AUDIO_TYPE_PROPERTY => $builder->withType($content),
                default => $builder,
            };
        }

        return $builder->build();
    }

    /**
     * @return VideoCollection<Video>
     */
    final public function videos(): VideoCollection
    {
        $properties = $this->scraper->getContentsByPrefix(MetaScraperInterface::VIDEO_PROPERTY);

        $builder = VideoCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === MetaScraperInterface::VIDEO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                MetaScraperInterface::VIDEO_PROPERTY => $builder->withUrl($content),
                MetaScraperInterface::VIDEO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                MetaScraperInterface::VIDEO_TYPE_PROPERTY => $builder->withType($content),
                MetaScraperInterface::VIDEO_WIDTH_PROPERTY => $builder->withWidth($content),
                MetaScraperInterface::VIDEO_HEIGHT_PROPERTY => $builder->withHeight($content),
                default => $builder,
            };
        }

        return $builder->build();
    }
}
