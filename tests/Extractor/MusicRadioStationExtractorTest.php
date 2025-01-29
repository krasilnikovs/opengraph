<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Extractor;

use Krasilnikovs\Opengraph\Extractor\MusicRadioStationExtractor;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MusicRadioStationExtractor::class)]
final class MusicRadioStationExtractorTest extends TestCase
{
    private MusicRadioStationExtractor $extractor;

    protected function setUp(): void
    {
        $html = <<<HTML
                <meta property="music:creator" content="https://lv.wikipedia.org/wiki/Raimonds_Pauls">
                <meta property="music:creator" content="https://lv.wikipedia.org/wiki/Laima_Vaikule">
            HTML;

        $this->extractor = MusicRadioStationExtractor::fromScraper(
            OpengraphScraper::fromString($html)
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
}
