<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Property\Builder;

use Krasilnikovs\Opengraph\Property\Builder\VideoCollectionBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VideoCollectionBuilder::class)]
final class VideoCollectionBuilderTest extends TestCase
{
    public function testShouldBuildList(): void
    {
        $videos = VideoCollectionBuilder::new()
            ->append()
            ->withUrl('http://krasilnikovs.lv/me.mp4')
            ->withSecureUrl('https://krasilnikovs.lv/me.mp4')
            ->withType('video/mp4')
            ->withWidth('120')
            ->withHeight('120')
            ->build()
        ;

        $expectedUrl = 'http://krasilnikovs.lv/me.mp4';
        $expectedSecureUrl = 'https://krasilnikovs.lv/me.mp4';
        $expectedType = 'video/mp4';
        $expectedWidth = '120';
        $expectedHeight = '120';

        self::assertCount(1, $videos);

        self::assertEquals($expectedUrl, $videos[0]?->url);
        self::assertEquals($expectedSecureUrl, $videos[0]?->secureUrl);
        self::assertEquals($expectedType, $videos[0]?->type);
        self::assertEquals($expectedWidth, $videos[0]?->width);
        self::assertEquals($expectedHeight, $videos[0]?->height);
    }

    public function testShouldBuildEmptyList(): void
    {
        $audios = VideoCollectionBuilder::new()
            ->withUrl('http://krasilnikovs.lv/me.mp4')
            ->withSecureUrl('https://krasilnikovs.lv/me.mp4')
            ->withType('video/mp4')
            ->withWidth('120')
            ->withHeight('120')
            ->build()
        ;

        self::assertCount(0, $audios);
    }
}
