<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Extractor;

use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class MusicRadioStationExtractor
{
    use PropertyExtractor;

    /**
     * @return list<string>
     */
    public function creators(): array
    {
        $creators = $this->scraper->getContentsByName(MetaScraperInterface::MUSIC_CREATOR_PROPERTY);

        return array_values(iterator_to_array($creators));
    }
}
