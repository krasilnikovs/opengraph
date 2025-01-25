<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Throwable;

final readonly class MusicAlbumPropertyExtractor
{
    use PropertyExtractor;

    public function releaseDate(): ?DateTimeImmutable
    {
        $releaseDate = $this->scraper->getContentByName(MetaScraperInterface::MUSIC_RELEASE_DATE_PROPERTY);

        try {
            return new DateTimeImmutable($releaseDate);
        } catch (Throwable) {
            return null;
        }
    }

    public function musicians(): UrlCollection
    {
        $musicians = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_MUSICIAN_PROPERTY);

        $musicians = array_map(Url::fromString(...), iterator_to_array($musicians));

        return UrlCollection::fromArray($musicians);
    }

    public function songs(): UrlCollection
    {
        $songs = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_SONG_PROPERTY);

        $songs = array_map(Url::fromString(...), iterator_to_array($songs));

        return UrlCollection::fromArray($songs);
    }
}
