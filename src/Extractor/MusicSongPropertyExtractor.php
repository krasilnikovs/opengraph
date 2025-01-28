<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use function array_map;

final readonly class MusicSongPropertyExtractor
{
    use PropertyExtractor;

    public function duration(): int
    {
        $duration = $this->scraper->getContentByName(OpengraphScraper::MUSIC_DURATION_PROPERTY);

        if (! is_numeric($duration)) {
            return 0;
        }

        return (int) $duration;
    }

    public function album(): Url
    {
        $url = $this->scraper->getContentByName(OpengraphScraper::MUSIC_ALBUM_PROPERTY);

        return Url::fromString($url);
    }

    public function musicians(): UrlCollection
    {
        $musicians = $this->scraper->getContentsByName(OpengraphScraper::MUSIC_MUSICIAN_PROPERTY);

        $musicians = array_map(Url::fromString(...), iterator_to_array($musicians));

        return UrlCollection::fromArray($musicians);
    }
}
