<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\TagCollection;

final readonly class ArticlePropertyExtractor
{
    use PropertyExtractor;

    public function author(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::ARTICLE_AUTHOR_PROPERTY);
    }

    public function section(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::ARTICLE_SECTION_PROPERTY);
    }

    public function tags(): TagCollection
    {
        $tags = $this->scraper->getContentsByName(OpengraphScraper::ARTICLE_TAG_PROPERTY);

        return new TagCollection(iterator_to_array($tags));
    }
}
