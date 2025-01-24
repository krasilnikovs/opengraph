<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class MusicSongPropertyExtractor
{
    use PropertyExtractor;

    public function duration(): int
    {
        $duration = $this->scraper->getContentByName(MetaScraperInterface::MUSIC_DURATION_PROPERTY);

        if (! is_numeric($duration)) {
            return 0;
        }

        return (int) $duration;
    }

    public function album(): string
    {
        return $this->scraper->getContentByName(MetaScraperInterface::MUSIC_ALBUM_PROPERTY);
    }

    /**
     * @return list<string>
     */
    public function musicians(): array
    {
        $musicians = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_MUSICIAN_PROPERTY);

        return array_values(iterator_to_array($musicians));
    }
}
