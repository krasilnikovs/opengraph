<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class MusicPlaylistPropertyExtractor
{
    use PropertyExtractor;

    public function creators(): UrlCollection
    {
        $creators = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_CREATOR_PROPERTY);

        $creators = array_map(Url::fromString(...), iterator_to_array($creators));

        return UrlCollection::fromArray($creators);
    }

    public function songs(): UrlCollection
    {
        $songs = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_SONG_PROPERTY);

        $songs = array_map(Url::fromString(...), iterator_to_array($songs));

        return UrlCollection::fromArray($songs);
    }
}
