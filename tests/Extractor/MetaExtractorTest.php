<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Extractor;

use Krasilnikovs\Opengraph\Extractor\MetaExtractor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetaExtractor::class)]
final class MetaExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $extractor = MetaExtractor::fromString($this->getContent());

        self::assertEquals('website', $extractor->type());
        self::assertEquals('Krasilnikovs Homepage', $extractor->title());
        self::assertEquals('https://krasilnikovs.lv/', $extractor->url());
        self::assertEquals('https://krasilnikovs.lv/static/me.webp', $extractor->images()[0]->url->value);
    }

    private function getContent(): string
    {
        return <<<HTML
            <!DOCTYPE html>
            <html>
                <head>
                    <meta property="og:type" content="website" />
                    <meta property="og:title" content="Krasilnikovs Homepage" />
                    <meta property="og:url" content="https://krasilnikovs.lv/" />
                    <meta property="og:image" content="https://krasilnikovs.lv/static/me.webp" />
                </head> 
                <body></body> 
            </html>
        HTML;
    }
}
