<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Property\Extractor;

use Krasilnikovs\Opengraph\Property\Extractor\MusicSongPropertyExtractor;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Scraper\MetaScraper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MusicSongPropertyExtractor::class)]
final class MusicSongPropertyExtractorTest extends TestCase
{
    private MusicSongPropertyExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="music:duration" content="1229">
                <meta property="music:album" content="https://open.spotify.com/album/2Zth5HSiPPSalmH5Rb5DNI?si=VSQ8ijioRJGOQIxUS3Q3Hg">
                <meta property="music:musician" content="https://lv.wikipedia.org/wiki/Raimonds_Pauls">
            HTML;

        $this->extractor = MusicSongPropertyExtractor::fromMetaScraper(
            MetaScraper::fromString($html)
        );
    }

    public function testShouldExtractDuration(): void
    {
        $expected = 1229;

        self::assertEquals($expected, $this->extractor->duration());
    }

    public function testShouldExtractAlbum(): void
    {
        $expected = Url::fromString('https://open.spotify.com/album/2Zth5HSiPPSalmH5Rb5DNI?si=VSQ8ijioRJGOQIxUS3Q3Hg');

        self::assertEquals($expected, $this->extractor->album());
    }


    public function testShouldExtractMusicians(): void
    {
        $expected = new UrlCollection([
            Url::fromString('https://lv.wikipedia.org/wiki/Raimonds_Pauls'),
        ]);

        self::assertEquals($expected, $this->extractor->musicians());
    }
}
