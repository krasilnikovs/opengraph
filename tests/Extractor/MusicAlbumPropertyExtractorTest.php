<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Extractor;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\Extractor\MusicAlbumPropertyExtractor;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MusicAlbumPropertyExtractor::class)]
final class MusicAlbumPropertyExtractorTest extends TestCase
{
    private MusicAlbumPropertyExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="music:release_date" content="2014-11-24">
                <meta property="music:musician" content="https://lv.wikipedia.org/wiki/Raimonds_Pauls">
                <meta property="music:song" content="https://open.spotify.com/track/488ppPsbOwN7T26XKuXruh?si=c44f580436ba440a">
                <meta property="music:song" content="https://open.spotify.com/track/030zL05q4n5QU2TvM5IMaq?si=a0edbb80e9014c8b">
            HTML;

        $this->extractor = MusicAlbumPropertyExtractor::fromScraper(
            OpengraphScraper::fromString($html)
        );
    }

    public function testShouldExtractReleaseDate(): void
    {
        $expected = new DateTimeImmutable('2014-11-24T00:00:00+00:00');

        self::assertEquals($expected, $this->extractor->releaseDate());
    }

    public function testShouldExtractMusicians(): void
    {
        $expected = UrlCollection::fromArray([
            Url::fromString('https://lv.wikipedia.org/wiki/Raimonds_Pauls'),
        ]);

        self::assertEquals($expected, $this->extractor->musicians());
    }


    public function testShouldExtractSongs(): void
    {
        $expected = UrlCollection::fromArray([
            Url::fromString('https://open.spotify.com/track/488ppPsbOwN7T26XKuXruh?si=c44f580436ba440a'),
            Url::fromString('https://open.spotify.com/track/030zL05q4n5QU2TvM5IMaq?si=a0edbb80e9014c8b'),
        ]);

        self::assertEquals($expected, $this->extractor->songs());
    }
}
