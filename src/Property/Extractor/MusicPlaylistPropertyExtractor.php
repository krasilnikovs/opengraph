<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class MusicPlaylistPropertyExtractor
{
    use PropertyExtractor;

    /**
     * @return list<string>
     */
    public function creators(): array
    {
        return $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_CREATOR_PROPERTY);
    }

    /**
     * @return list<string>
     */
    public function songs(): array
    {
        return $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_SONG_PROPERTY);
    }
}
