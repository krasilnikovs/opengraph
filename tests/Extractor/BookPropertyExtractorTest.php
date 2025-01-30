<?php declare(strict_types=1);

namespace Extractor;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\Extractor\BookPropertyExtractor;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\TagCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BookPropertyExtractor::class)]
final class BookPropertyExtractorTest extends TestCase
{
    private BookPropertyExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="og:type" content="book">
                <meta property="og:title" content="Patterns of Enterprise Application Architecture">
                <meta property="og:url" content="https://martinfowler.com/books/eaa.html">
                <meta property="og:image" content="https://martinfowler.com/books/eaa.jpg">
                <meta property="og:description" content="The book is a Duplex Book. The first part is a short (100 page) tutorial on enterprise application architecture. The bulk of the book is the reference to forty or so patterns. All of these patterns are ones that I've seen in the field, usually on many different programming platforms.">
                <meta property="book:isbn" content="9780321127426">
                <meta property="book:author" content="Martin Fowler">
                <meta property="book:release_date" content="2002-11-05">
                <meta property="book:tag" content="patterns">
                <meta property="book:tag" content="enterprise">
            HTML;

        $this->extractor = BookPropertyExtractor::fromScraper(
            OpengraphScraper::fromString($html)
        );
    }

    public function testShouldExtractIsbn(): void
    {
        $expected = '9780321127426';

        self::assertEquals($expected, $this->extractor->isbn());
    }

    public function testShouldExtractAuthor(): void
    {
        $expected = 'Martin Fowler';

        self::assertEquals($expected, $this->extractor->author());
    }

    public function testShouldExtractReleaseDate(): void
    {
        $expected = new DateTimeImmutable('2002-11-05');

        self::assertEquals($expected, $this->extractor->releaseDate());
    }


    public function testShouldExtractTags(): void
    {
        $expected = new TagCollection(['patterns', 'enterprise']);

        self::assertEquals($expected, $this->extractor->tags());
    }
}
