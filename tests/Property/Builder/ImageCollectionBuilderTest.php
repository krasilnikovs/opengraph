<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Property\Builder;

use Krasilnikovs\Opengraph\Property\Builder\ImageCollectionBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImageCollectionBuilder::class)]
final class ImageCollectionBuilderTest extends TestCase
{
    public function testShouldBuildList(): void
    {
        $audios = ImageCollectionBuilder::new()
            ->append()
            ->withUrl('http://krasilnikovs.lv/me.png')
            ->withSecureUrl('https://krasilnikovs.lv/me.png')
            ->withType('image/png')
            ->withWidth('120')
            ->withHeight('120')
            ->withAlt('Krasilnikovs selfie')
            ->build()
        ;

        $expectedUrl = 'http://krasilnikovs.lv/me.png';
        $expectedSecureUrl = 'https://krasilnikovs.lv/me.png';
        $expectedType = 'image/png';
        $expectedWidth = '120';
        $expectedHeight = '120';
        $expectedAlt = 'Krasilnikovs selfie';
        
        self::assertCount(1, $audios);

        self::assertEquals($expectedUrl, $audios[0]?->url);
        self::assertEquals($expectedSecureUrl, $audios[0]?->secureUrl);
        self::assertEquals($expectedType, $audios[0]?->type);
        self::assertEquals($expectedWidth, $audios[0]?->width);
        self::assertEquals($expectedHeight, $audios[0]?->height);
        self::assertEquals($expectedAlt, $audios[0]?->alt);
    }

    public function testShouldBuildEmptyList(): void
    {
        $audios = ImageCollectionBuilder::new()
            ->withUrl('http://krasilnikovs.lv/me.png')
            ->withSecureUrl('https://krasilnikovs.lv/me.png')
            ->withType('image/png')
            ->withWidth('120')
            ->withHeight('120')
            ->withAlt('Krasilnikovs selfie')
            ->build()
        ;

        self::assertCount(0, $audios);
    }
}
