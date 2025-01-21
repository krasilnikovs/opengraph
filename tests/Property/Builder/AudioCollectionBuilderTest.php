<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Property\Builder;

use Krasilnikovs\Opengraph\Property\Builder\AudioCollectionBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AudioCollectionBuilder::class)]
final class AudioCollectionBuilderTest extends TestCase
{
    public function testShouldBuildList(): void
    {
        $audios = AudioCollectionBuilder::new()
            ->append()
            ->withUrl('http://krasilnikovs.lv/audio.mp3')
            ->withSecureUrl('https://krasilnikovs.lv/audio.mp3')
            ->withType('audio/mp3')

            ->build()
        ;

        $expectedUrl = 'http://krasilnikovs.lv/audio.mp3';
        $expectedSecureUrl = 'https://krasilnikovs.lv/audio.mp3';
        $expectedType = 'audio/mp3';

        self::assertCount(1, $audios);

        self::assertEquals($expectedUrl, $audios[0]?->url);
        self::assertEquals($expectedSecureUrl, $audios[0]?->secureUrl);
        self::assertEquals($expectedType, $audios[0]?->type);
    }

    public function testShouldBuildEmptyList(): void
    {
        $audios = AudioCollectionBuilder::new()
            ->withUrl('http://krasilnikovs.lv/audio.mp3')
            ->withSecureUrl('https://krasilnikovs.lv/audio.mp3')
            ->withType('audio/mp3')

            ->build()
        ;

        self::assertCount(0, $audios);
    }
}
