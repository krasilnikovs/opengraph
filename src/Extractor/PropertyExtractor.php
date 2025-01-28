<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\OpengraphScraper;
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

trait PropertyExtractor
{
    final public function __construct(
        protected readonly OpengraphScraper $scraper,
    ) {}

    final public static function fromMetaScraper(OpengraphScraper $scraper): static
    {
        return new static($scraper);
    }

    final public function type(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::TYPE_PROPERTY);
    }

    /**
     * @throws PropertyNotExtractedException
     */
    final public function url(): Url
    {
        $url = $this->scraper->getContentByName(OpengraphScraper::URL_PROPERTY);

        if ($url === '') {
            throw PropertyNotExtractedException::requiredNotEmptyValueForProperty(OpengraphScraper::URL_PROPERTY);
        }

        return Url::fromString($url);
    }

    /**
     * @throws PropertyNotExtractedException
     */
    final public function title(): string
    {
        $title = $this->scraper->getContentByName(OpengraphScraper::TITLE_PROPERTY);

        if ($title === '') {
            throw PropertyNotExtractedException::requiredNotEmptyValueForProperty(OpengraphScraper::TITLE_PROPERTY);
        }

        return $title;
    }

    final public function description(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::DESCRIPTION_PROPERTY);
    }

    final public function siteName(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::SITE_NAME_PROPERTY);
    }

    final public function determiner(): Determiner
    {
        $value = $this->scraper->getContentByName(OpengraphScraper::DETERMINER_PROPERTY);

        $determiner = Determiner::tryFrom($value);

        if ($determiner === null) {
            $determiner = Determiner::Empty;
        }

        return $determiner;
    }

    final public function locale(): Locale
    {
        $alternates = $this->scraper->getContentsByName(OpengraphScraper::LOCALE_ALTERNATE_PROPERTY);

        $locale = $this->scraper->getContentByName(OpengraphScraper::LOCALE_PROPERTY);

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
        $properties = $this->scraper->getContentsByPrefix(OpengraphScraper::IMAGE_PROPERTY);

        $builder = ImageCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($content === '') {
                continue;
            }

            if ($property === OpengraphScraper::IMAGE_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                OpengraphScraper::IMAGE_PROPERTY => $builder->withUrl($content),
                OpengraphScraper::IMAGE_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                OpengraphScraper::IMAGE_TYPE_PROPERTY => $builder->withType($content),
                OpengraphScraper::IMAGE_WIDTH_PROPERTY => $builder->withWidth($content),
                OpengraphScraper::IMAGE_HEIGHT_PROPERTY => $builder->withHeight($content),
                OpengraphScraper::IMAGE_ALT_PROPERTY => $builder->withAlt($content),
                default => $builder,
            };
        }

        if ($builder->isEmpty()) {
            throw PropertyNotExtractedException::atLeastOneElementRequiredForProperty(OpengraphScraper::IMAGE_PROPERTY);
        }

        return $builder->build();
    }

    /**
     * @return AudioCollection<Audio>
     */
    final public function audios(): AudioCollection
    {
        $properties = $this->scraper->getContentsByPrefix(OpengraphScraper::AUDIO_PROPERTY);

        $builder = AudioCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === OpengraphScraper::AUDIO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                OpengraphScraper::AUDIO_PROPERTY => $builder->withUrl($content),
                OpengraphScraper::AUDIO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                OpengraphScraper::AUDIO_TYPE_PROPERTY => $builder->withType($content),
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
        $properties = $this->scraper->getContentsByPrefix(OpengraphScraper::VIDEO_PROPERTY);

        $builder = VideoCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === OpengraphScraper::VIDEO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                OpengraphScraper::VIDEO_PROPERTY => $builder->withUrl($content),
                OpengraphScraper::VIDEO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                OpengraphScraper::VIDEO_TYPE_PROPERTY => $builder->withType($content),
                OpengraphScraper::VIDEO_WIDTH_PROPERTY => $builder->withWidth($content),
                OpengraphScraper::VIDEO_HEIGHT_PROPERTY => $builder->withHeight($content),
                default => $builder,
            };
        }

        return $builder->build();
    }
}
