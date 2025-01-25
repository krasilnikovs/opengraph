<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Extractor;

use Krasilnikovs\Opengraph\Extractor\MusicPlaylistPropertyExtractor;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Scraper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MusicPlaylistPropertyExtractor::class)]
final class MusicPlaylistExtractorTest extends TestCase
{
    private MusicPlaylistPropertyExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="music:creator" content="https://lv.wikipedia.org/wiki/Raimonds_Pauls">
                <meta property="music:creator" content="https://lv.wikipedia.org/wiki/Laima_Vaikule">
                <meta property="music:song" content="https://open.spotify.com/track/3mIHMq9PRupFlTdO2HsMMy?si=aa115bc1cfd44ad7">
            HTML;

        $this->extractor = MusicPlaylistPropertyExtractor::fromMetaScraper(
            Scraper::fromString($html)
        );
    }

    public function testShouldExtractCreators(): void
    {
        $expected = UrlCollection::fromArray([
            Url::fromString('https://lv.wikipedia.org/wiki/Raimonds_Pauls'),
            Url::fromString('https://lv.wikipedia.org/wiki/Laima_Vaikule'),
        ]);

        self::assertEquals($expected, $this->extractor->creators());
    }

    public function testShouldExtractSongs(): void
    {
        $expected = UrlCollection::fromArray([
            Url::fromString('https://open.spotify.com/track/3mIHMq9PRupFlTdO2HsMMy?si=aa115bc1cfd44ad7'),
        ]);

        self::assertEquals($expected, $this->extractor->songs());
    }
}
