<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Extractor;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractor;
use Krasilnikovs\Opengraph\Extractor\PropertyNotExtractedException;
use Krasilnikovs\Opengraph\Extractor\WebsitePropertyExtractor;
use Krasilnikovs\Opengraph\OpengraphScraper;
use Krasilnikovs\Opengraph\Property\Audio;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\Image;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Locale;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\Video;
use Krasilnikovs\Opengraph\Property\VideoCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(PropertyExtractor::class)]
final class PropertyExtractorTest extends TestCase
{
    public function testShouldExtractType(): void
    {
        $content = '<meta property="og:type" content="website">';

        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $expected = 'website';
        $actual = $extractor->type();

        self::assertEquals($expected, $actual);
    }

    public function testShouldExtractUrl(): void
    {
        $content = '<meta property="og:url" content="https://krasilnikovs.lv">';

        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $expected = Url::fromString('https://krasilnikovs.lv');
        $actual = $extractor->url();

        self::assertEquals($expected, $actual);
    }

    public function testShouldExtractTitle(): void
    {
        $content = '<meta property="og:title" content="Mihails Krasilnikovs">';

        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $expected = 'Mihails Krasilnikovs';
        $actual = $extractor->title();

        self::assertEquals($expected, $actual);
    }

    public function testShouldExtractDescription(): void
    {
        $content = '<meta property="og:description" content="Hey! I\'m Mihails Krasilnikovs, a Software Engineer from Latvia.">';

        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $expected = "Hey! I'm Mihails Krasilnikovs, a Software Engineer from Latvia.";
        $actual = $extractor->description();

        self::assertEquals($expected, $actual);
    }

    public function testShouldExtractSiteName(): void
    {
        $content = '<meta property="og:site_name" content="Krasilnikovs">';

        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $expected ='Krasilnikovs';
        $actual = $extractor->siteName();

        self::assertEquals($expected, $actual);
    }

    #[DataProvider('shouldExtractDeterminerProvider')]
    public function testShouldExtractDeterminer(string $content, Determiner $expected): void
    {
        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $actual = $extractor->determiner();

        self::assertEquals($expected, $actual);
    }

    #[DataProvider('shouldExtractLocaleProvider')]
    public function testShouldExtractLocale(string $content, Locale $expected): void
    {
        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $actual = $extractor->locale();

        self::assertEquals($expected, $actual);
    }

    #[DataProvider('shouldExtractImagesProvider')]
    public function testShouldExtractImages(string $content, ImageCollection $expected): void
    {
        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $actual = $extractor->images();

        self::assertEquals($expected, $actual);
    }

    public function testShouldThrowExceptionIfNoImages(): void
    {
        $this->expectException(PropertyNotExtractedException::class);
        $this->expectExceptionMessage('At least one element required for property "og:image"');

        $extractor = WebsitePropertyExtractor::fromMetaScraper(
            OpengraphScraper::fromString('')
        );

        $extractor->images();
    }

    #[DataProvider('shouldExtractAudiosProvider')]
    public function testShouldExtractAudios(string $content, AudioCollection $expected): void
    {
        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $actual = $extractor->audios();

        self::assertEquals($expected, $actual);
    }

    #[DataProvider('shouldExtractVideosProvider')]
    public function testShouldExtractVideos(string $content, VideoCollection $expected): void
    {
        $extractor = new class(OpengraphScraper::fromString($content)) {
            use PropertyExtractor;
        };

        $actual = $extractor->videos();

        self::assertEquals($expected, $actual);
    }

    /**
     * @return array<string, array{content: string, expected: Locale}>
     */
    public static function shouldExtractLocaleProvider(): array
    {
        return [
            'not-empty-content' => [
                'content' => <<<HTML
                        <meta property="og:locale" content="en_US">
                        <meta property="og:locale:alternate" content="lv">          
                        <meta property="og:locale:alternate" content="ru">          
                    HTML,
                'expected' => new Locale('en_US', ['lv', 'ru']),
            ],
            'empty-content' => [
                'content' => '',
                'expected' => new Locale('en_US', []),
            ],
        ];
    }


    /**
     * @return array<string, array{content: string, expected: Determiner}>
     */
    public static function shouldExtractDeterminerProvider(): array
    {
        return [
            'the' => [
                'content' => '<meta property="og:determiner" content="the" />',
                'expected' => Determiner::The,
            ],
            'a' => [
                'content' => '<meta property="og:determiner" content="a" />',
                'expected' => Determiner::A,
            ],
            'an' => [
                'content' => '<meta property="og:determiner" content="an" />',
                'expected' => Determiner::An,
            ],
            'auto' => [
                'content' => '<meta property="og:determiner" content="auto" />',
                'expected' => Determiner::Auto,
            ],
            'empty' => [
                'content' => '<meta property="og:determiner" content="" />',
                'expected' => Determiner::Empty,
            ],
            'not-enum-value' => [
                'content' => '<meta property="og:determiner" content="The123" />',
                'expected' => Determiner::Empty,
            ],
            'empty-content' => [
                'content' => '',
                'expected' => Determiner::Empty,
            ],
        ];
    }

    /**
     * @return array<string, array{content: string, expected: ImageCollection}>
     */
    public static function shouldExtractImagesProvider(): array
    {
        return [
            'not-empty' => [
                'content' => <<<HTML
                        <meta property="og:image" content="https://krasilnikovs.lv/static/me.webp">
                        <meta property="og:image:secure_url" content="https://krasilnikovs.lv/static/me_secure.webp">
                        <meta property="og:image:type" content="image/webp">
                        <meta property="og:image:width" content="128">
                        <meta property="og:image:height" content="128">
                        <meta property="og:image:alt" content="Mihails Krasilnikovs">
                        <meta property="og:image:mistake" content="ping">
                    HTML,
                'expected' => new ImageCollection([
                    Image::new(
                        url: 'https://krasilnikovs.lv/static/me.webp',
                        secureUrl: 'https://krasilnikovs.lv/static/me_secure.webp',
                        type: 'image/webp',
                        width: '128',
                        height: '128',
                        alt: 'Mihails Krasilnikovs',
                    ),
                ]),
            ],
        ];
    }

    /**
     * @return array<string, array{content: string, expected: AudioCollection}>
     */
    public static function shouldExtractAudiosProvider(): array
    {
        return [
            'not-empty' => [
                'content' => <<<HTML
                        <meta property="og:audio" content="https://krasilnikovs.lv/static/me.mp3">
                        <meta property="og:audio:secure_url" content="https://krasilnikovs.lv/static/me_secure.mp3">
                        <meta property="og:audio:type" content="audio/mp3">
                        <meta property="og:audio:mistake" content="ping">
                    HTML,
                'expected' => new AudioCollection([
                    Audio::new(
                        url: 'https://krasilnikovs.lv/static/me.mp3',
                        secureUrl: 'https://krasilnikovs.lv/static/me_secure.mp3',
                        type: 'audio/mp3',
                    ),
                ]),
            ],
            'empty' => [
                'content' => '',
                'expected' => new AudioCollection([]),
            ],
        ];
    }

    /**
     * @return array<string, array{content: string, expected: VideoCollection}>
     */
    public static function shouldExtractVideosProvider(): array
    {
        return [
            'not-empty' => [
                'content' => <<<HTML
                        <meta property="og:video" content="https://krasilnikovs.lv/static/me.mp4">
                        <meta property="og:video:secure_url" content="https://krasilnikovs.lv/static/me_secure.mp4">
                        <meta property="og:video:type" content="image/mp4">
                        <meta property="og:video:width" content="128">
                        <meta property="og:video:height" content="128">
                        <meta property="og:video:mistake" content="ping">
                    HTML,
                'expected' => new VideoCollection([
                    Video::new(
                        url: 'https://krasilnikovs.lv/static/me.mp4',
                        secureUrl: 'https://krasilnikovs.lv/static/me_secure.mp4',
                        type: 'image/mp4',
                        width: '128',
                        height: '128',
                    ),
                ]),
            ],
            'empty' => [
                'content' => '',
                'expected' => new VideoCollection([]),
            ],
        ];
    }
}
