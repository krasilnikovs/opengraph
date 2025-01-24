<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Property\Extractor;

use Krasilnikovs\Opengraph\Property\Extractor\MusicRadioStationExtractor;
use Krasilnikovs\Opengraph\Scraper\MetaScraper;
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

        $this->extractor = MusicRadioStationExtractor::fromMetaScraper(
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
}
