<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use DateTimeImmutable;
use DateTimeInterface;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Throwable;

final readonly class MusicAlbumPropertyExtractor
{
    use PropertyExtractor;

    public function releaseDate(): string
    {
        $releaseDate = $this->scraper->getContentByName(MetaScraperInterface::MUSIC_RELEASE_DATE_PROPERTY);

        try {
            return new DateTimeImmutable($releaseDate)->format(DateTimeInterface::ATOM);
        } catch (Throwable) {
            return '';
        }
    }

    /**
     * @return list<string>
     */
    public function musicians(): array
    {
        $musicians = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_MUSICIAN_PROPERTY);

        return array_values(iterator_to_array($musicians));
    }

    /**
     * @return list<string>
     */
    public function songs(): array
    {
        $songs = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_SONG_PROPERTY);

        return array_values(iterator_to_array($songs));
    }
}
