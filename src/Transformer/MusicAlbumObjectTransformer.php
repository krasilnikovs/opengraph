<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\MusicAlbumObject;
use Krasilnikovs\Opengraph\Property\Extractor\PropertyExtractor;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

final readonly class MusicAlbumObjectTransformer implements ObjectTransformerInterface
{
    public function supports(MetaScraperInterface $scraper): bool
    {
        $extractor = PropertyExtractor::fromMetaScraper($scraper);

        return $extractor->type() === MusicAlbumObject::getType();
    }

    public function toObject(MetaScraperInterface $scraper): AbstractObject
    {
        $base = new WebsiteObjectTransformer()->toObject($scraper);

        $extractor = PropertyExtractor::fromMetaScraper($scraper);

        return new MusicAlbumObject(
            url:         $base->url,
            title:       $base->title,
            description: $base->description,
            siteName:    $base->siteName,
            determiner:  $base->determiner,
            images:      $base->images,
            audios:      $base->audios,
            videos:      $base->videos,
            releaseDate: $extractor->musicAlbum()->releaseDate(),
            musicians:   $extractor->musicAlbum()->musicians(),
            songs:       $extractor->musicAlbum()->songs(),
        );
    }
}
