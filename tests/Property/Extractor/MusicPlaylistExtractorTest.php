<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Property\Extractor;

use Krasilnikovs\Opengraph\Property\Extractor\MusicPlaylistPropertyExtractor;
use Krasilnikovs\Opengraph\Scraper\MetaScraper;
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
            MetaScraper::fromString($html)
        );
    }

    public function testShouldExtractCreators(): void
    {
        $expected = [
            'https://lv.wikipedia.org/wiki/Raimonds_Pauls',
            'https://lv.wikipedia.org/wiki/Laima_Vaikule',
        ];

        self::assertEquals($expected, $this->extractor->creators());
    }

    public function testShouldExtractSongs(): void
    {
        $expected = [
            'https://open.spotify.com/track/3mIHMq9PRupFlTdO2HsMMy?si=aa115bc1cfd44ad7',
        ];

        self::assertEquals($expected, $this->extractor->songs());
    }
}
