<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\ProfilePropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\ProfileObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

final readonly class ProfileObjectTransformer implements ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool
    {
        $extractor = ProfilePropertyExtractor::fromScraper($scraper);

        return $extractor->type() === ProfileObject::getType();
    }

    public function toObject(OpengraphScraper $scraper): AbstractObject
    {
        $extractor = ProfilePropertyExtractor::fromScraper($scraper);

        return new ProfileObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            firstName:   $extractor->firstName(),
            lastName:    $extractor->lastName(),
            username:    $extractor->username(),
            gender:      $extractor->gender(),
        );
    }
}
