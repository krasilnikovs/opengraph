<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MusicRadioStationExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicRadioStationObject;
use Krasilnikovs\Opengraph\Scraper;

final readonly class MusicRadioStationObjectTransformer implements ObjectTransformerInterface
{
    public function supports(Scraper $scraper): bool
    {
        $extractor = MusicRadioStationExtractor::fromMetaScraper($scraper);

        return $extractor->type() === MusicRadioStationObject::getType();
    }

    public function toObject(Scraper $scraper): AbstractObject
    {
        $extractor = MusicRadioStationExtractor::fromMetaScraper($scraper);

        return new MusicRadioStationObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            creators:    $extractor->creators(),
        );
    }

}
