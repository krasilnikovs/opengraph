<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\TagCollection;
use Throwable;

final readonly class BookPropertyExtractor
{
    use PropertyExtractor;

    public function isbn(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::BOOK_ISBN_PROPERTY);
    }

    public function author(): string
    {
        return $this->scraper->getContentByName(OpengraphScraper::BOOK_AUTHOR_PROPERTY);
    }

    public function releaseDate(): ?DateTimeImmutable
    {
        $releaseDate = $this->scraper->getContentByName(OpengraphScraper::BOOK_RELEASE_DATE_PROPERTY);

        try {
            return new DateTimeImmutable($releaseDate);
        } catch (Throwable) {
            return null;
        }
    }

    public function tags(): TagCollection
    {
        $tags = $this->scraper->getContentsByName(OpengraphScraper::BOOK_TAG_PROPERTY);

        return new TagCollection(iterator_to_array($tags));
    }
}
