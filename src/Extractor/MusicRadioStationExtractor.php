<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;

final readonly class MusicRadioStationExtractor
{
    use PropertyExtractor;

    public function creators(): UrlCollection
    {
        $creators = $this->scraper->getContentsByName(OpengraphScraper::MUSIC_CREATOR_PROPERTY);

        $creators = array_map(Url::fromString(...), iterator_to_array($creators));

        return UrlCollection::fromArray($creators);
    }
}
