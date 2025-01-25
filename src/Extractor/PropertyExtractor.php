<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\Property\Audio;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Builder\AudioCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\ImageCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\VideoCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\Image;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Locale;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\Video;
use Krasilnikovs\Opengraph\Property\VideoCollection;
use Krasilnikovs\Opengraph\Scraper;

trait PropertyExtractor
{
    final public function __construct(
        protected readonly Scraper $scraper,
    )
    {
    }

    final public static function fromMetaScraper(Scraper $scraper): static
    {
        return new static($scraper);
    }

    final public function type(): string
    {
        return $this->scraper->getContentByName(Scraper::TYPE_PROPERTY);
    }

    /**
     * @throws PropertyNotExtractedException
     */
    final public function url(): Url
    {
        $url = $this->scraper->getContentByName(Scraper::URL_PROPERTY);

        if ($url === '') {
            throw PropertyNotExtractedException::requiredNotEmptyValueForProperty(Scraper::URL_PROPERTY);
        }

        return Url::fromString($url);
    }

    /**
     * @throws PropertyNotExtractedException
     */
    final public function title(): string
    {
        $title = $this->scraper->getContentByName(Scraper::TITLE_PROPERTY);

        if ($title === '') {
            throw PropertyNotExtractedException::requiredNotEmptyValueForProperty(Scraper::TITLE_PROPERTY);
        }

        return $title;
    }

    final public function description(): string
    {
        return $this->scraper->getContentByName(Scraper::DESCRIPTION_PROPERTY);
    }

    final public function siteName(): string
    {
        return $this->scraper->getContentByName(Scraper::SITE_NAME_PROPERTY);
    }

    final public function determiner(): Determiner
    {
        $value = $this->scraper->getContentByName(Scraper::DETERMINER_PROPERTY);

        $determiner = Determiner::tryFrom($value);

        if ($determiner === null) {
            $determiner = Determiner::Empty;
        }

        return $determiner;
    }

    final public function locale(): Locale
    {
        $alternates = $this->scraper->getContentsByName(Scraper::LOCALE_ALTERNATE_PROPERTY);

        $locale = $this->scraper->getContentByName(Scraper::LOCALE_PROPERTY);

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
        $properties = $this->scraper->getContentsByPrefix(Scraper::IMAGE_PROPERTY);

        $builder = ImageCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($content === '') {
                continue;
            }

            if ($property === Scraper::IMAGE_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                Scraper::IMAGE_PROPERTY => $builder->withUrl($content),
                Scraper::IMAGE_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                Scraper::IMAGE_TYPE_PROPERTY => $builder->withType($content),
                Scraper::IMAGE_WIDTH_PROPERTY => $builder->withWidth($content),
                Scraper::IMAGE_HEIGHT_PROPERTY => $builder->withHeight($content),
                Scraper::IMAGE_ALT_PROPERTY => $builder->withAlt($content),
                default => $builder,
            };
        }

        if ($builder->isEmpty()) {
            throw PropertyNotExtractedException::atLeastOneElementRequiredForProperty(Scraper::IMAGE_PROPERTY);
        }

        return $builder->build();
    }

    /**
     * @return AudioCollection<Audio>
     */
    final public function audios(): AudioCollection
    {
        $properties = $this->scraper->getContentsByPrefix(Scraper::AUDIO_PROPERTY);

        $builder = AudioCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === Scraper::AUDIO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                Scraper::AUDIO_PROPERTY => $builder->withUrl($content),
                Scraper::AUDIO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                Scraper::AUDIO_TYPE_PROPERTY => $builder->withType($content),
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
        $properties = $this->scraper->getContentsByPrefix(Scraper::VIDEO_PROPERTY);

        $builder = VideoCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === Scraper::VIDEO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                Scraper::VIDEO_PROPERTY => $builder->withUrl($content),
                Scraper::VIDEO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                Scraper::VIDEO_TYPE_PROPERTY => $builder->withType($content),
                Scraper::VIDEO_WIDTH_PROPERTY => $builder->withWidth($content),
                Scraper::VIDEO_HEIGHT_PROPERTY => $builder->withHeight($content),
                default => $builder,
            };
        }

        return $builder->build();
    }
}
