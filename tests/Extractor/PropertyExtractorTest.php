<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Extractor;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PropertyExtractor::class)]
final class PropertyExtractorTest extends TestCase
{
    public function testExtract(): void
    {
        $extractor = PropertyExtractor::fromString($this->getContent());

        self::assertEquals('website', $extractor->type()->content);
        self::assertEquals('Krasilnikovs Homepage', $extractor->title()->content);
        self::assertEquals('https://krasilnikovs.lv/', $extractor->url()->content);
        self::assertEquals('https://krasilnikovs.lv/static/me.webp', $extractor->images()[0]->content);
        self::assertEquals('https://secure.krasilnikovs.lv/static/me.webp', $extractor->images()[0]->secureUrl->content);
        self::assertEquals('https://krasilnikovs.lv/static/me.mp3', $extractor->audios()[0]->content);
        self::assertEquals('https://krasilnikovs.lv/static/me2.mp3', $extractor->audios()[1]->content);
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
                        <meta property="og:image:secure_url" content="https://secure.krasilnikovs.lv/static/me.webp" />
                        <meta property="og:audio" content="https://krasilnikovs.lv/static/me.mp3" />
                        <meta property="og:audio" content="https://krasilnikovs.lv/static/me2.mp3" />
                    </head> 
                    <body></body> 
                </html>
            HTML;
    }
}
