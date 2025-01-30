<?php declare(strict_types=1);

namespace Extractor;

use Krasilnikovs\Opengraph\Extractor\ArticlePropertyExtractor;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\TagCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArticlePropertyExtractor::class)]
final class ArticlePropertyExtractorTest extends TestCase
{
    private ArticlePropertyExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="og:type" content="article">
                <meta property="og:title" content="Good design means it's easy-to-change">
                <meta property="og:url" content="https://matthiasnoback.nl/2022/09/good-design-means-easy-to-change/">
                <meta property="og:image" content="https://matthiasnoback.nl/images/matthias-noback-small.jpg">
                <meta property="og:description" content="PHP 8.4.3 Released!">
                <meta property="article:author" content="Matthias Noback">
                <meta property="article:section" content="Technology">
                <meta property="article:tag" content="DDD">
                <meta property="article:tag" content="php">
            HTML;

        $this->extractor = ArticlePropertyExtractor::fromScraper(
            OpengraphScraper::fromString($html)
        );
    }

    public function testShouldExtractAuthor(): void
    {
        $expected = 'Matthias Noback';

        self::assertEquals($expected, $this->extractor->author());
    }

    public function testShouldExtractSection(): void
    {
        $expected = 'Technology';

        self::assertEquals($expected, $this->extractor->section());
    }

    public function testShouldExtractTags(): void
    {
        $expected = new TagCollection(['DDD', 'php']);

        self::assertEquals($expected, $this->extractor->tags());
    }
}
