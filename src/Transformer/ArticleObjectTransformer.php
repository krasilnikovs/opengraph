<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\ArticlePropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\ArticleObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

final readonly class ArticleObjectTransformer implements ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool
    {
        $extractor = ArticlePropertyExtractor::fromScraper($scraper);

        return $extractor->type() === ArticleObject::getType();
    }

    public function toObject(OpengraphScraper $scraper): AbstractObject
    {
        $extractor = ArticlePropertyExtractor::fromScraper($scraper);

        return new ArticleObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
            tags:        $extractor->tags(),
            author:      $extractor->author(),
            section:     $extractor->section(),
        );
    }
}
