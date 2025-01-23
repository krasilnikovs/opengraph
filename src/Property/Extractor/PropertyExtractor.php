<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use Krasilnikovs\Opengraph\Property\Audio;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Builder\AudioCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\ImageCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Builder\VideoCollectionBuilder;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\Image;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Locale;
use Krasilnikovs\Opengraph\Property\MusicAlbum;
use Krasilnikovs\Opengraph\Property\Video;
use Krasilnikovs\Opengraph\Property\VideoCollection;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class PropertyExtractor
{
    private function __construct(
        private MetaScraperInterface $scraper,
    ) {}

    public static function fromMetaScraper(MetaScraperInterface $scraper): self
    {
        return new self($scraper);
    }

    public function type(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::TYPE_PROPERTY);
    }

    public function url(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::URL_PROPERTY);
    }

    public function title(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::TITLE_PROPERTY);
    }

    public function description(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::DESCRIPTION_PROPERTY);
    }

    public function siteName(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::SITE_NAME_PROPERTY);
    }

    public function determiner(): Determiner
    {
        $value = $this->scraper->getContentByName(MetaScraperInterface::DETERMINER_PROPERTY);

        $determiner = Determiner::tryFrom($value);

        if (null === $determiner) {
            $determiner = Determiner::Empty;
        }

        return $determiner;
    }

    public function locale(): Locale
    {
        $alternates = $this->scraper->getContentsByName(MetaScraperInterface::LOCALE_ALTERNATE_PROPERTY);

        $locale = $this->scraper->getContentByName(MetaScraperInterface::LOCALE_PROPERTY);

        if (empty($locale)) {
            $locale = Locale::DEFAULT_LOCALE;
        }

        return Locale::new($locale, iterator_to_array($alternates));
    }

    /**
     * @return ImageCollection<Image>
     */
    public function images(): ImageCollection
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
                MetaScraperInterface::IMAGE_PROPERTY            => $builder->withUrl($content),
                MetaScraperInterface::IMAGE_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                MetaScraperInterface::IMAGE_TYPE_PROPERTY       => $builder->withType($content),
                MetaScraperInterface::IMAGE_WIDTH_PROPERTY      => $builder->withWidth($content),
                MetaScraperInterface::IMAGE_HEIGHT_PROPERTY     => $builder->withHeight($content),
                MetaScraperInterface::IMAGE_ALT_PROPERTY        => $builder->withAlt($content),
                default                                         => $builder,
            };
        }

        return $builder->build();
    }

    /**
     * @return AudioCollection<Audio>
     */
    public function audios(): AudioCollection
    {
        $properties = $this->scraper->getContentsByPrefix(MetaScraperInterface::AUDIO_PROPERTY);

        $builder = AudioCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === MetaScraperInterface::AUDIO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                MetaScraperInterface::AUDIO_PROPERTY            => $builder->withUrl($content),
                MetaScraperInterface::AUDIO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                MetaScraperInterface::AUDIO_TYPE_PROPERTY       => $builder->withType($content),
                default                                         => $builder,
            };
        }

        return $builder->build();
    }

    /**
     * @return VideoCollection<Video>
     */
    public function videos(): VideoCollection
    {
        $properties = $this->scraper->getContentsByPrefix(MetaScraperInterface::VIDEO_PROPERTY);

        $builder = VideoCollectionBuilder::new();

        foreach ($properties as [$property, $content]) {

            if ($property === MetaScraperInterface::VIDEO_PROPERTY) {
                $builder = $builder->append();
            }

            $builder = match ($property) {
                MetaScraperInterface::VIDEO_PROPERTY            => $builder->withUrl($content),
                MetaScraperInterface::VIDEO_SECURE_URL_PROPERTY => $builder->withSecureUrl($content),
                MetaScraperInterface::VIDEO_TYPE_PROPERTY       => $builder->withType($content),
                MetaScraperInterface::VIDEO_WIDTH_PROPERTY      => $builder->withWidth($content),
                MetaScraperInterface::VIDEO_HEIGHT_PROPERTY     => $builder->withHeight($content),
                default                                         => $builder,
            };
        }

        return $builder->build();
    }

    public function musicAlbum(): MusicAlbum
    {
        $releaseDate = $this->scraper->getContentByName(MetaScraperInterface::MUSIC_RELEASE_DATE_PROPERTY);
        $musicians   = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_MUSICIAN_PROPERTY);
        $songs       = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_SONG_PROPERTY);

        return new MusicAlbum(
            releaseDate: $releaseDate,
            musicians: array_values(iterator_to_array($musicians)),
            songs: array_values(iterator_to_array($songs)),
        );
    }
}
