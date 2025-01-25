<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Object\MusicAlbumObject;
use Krasilnikovs\Opengraph\Property\Extractor\Exception\PropertyNotExtractedException;
use Krasilnikovs\Opengraph\Transformer\MusicAlbumObjectTransformer;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(MusicAlbumObjectTransformer::class)]
final class MusicAlbumObjectTransformerTest extends ObjectTransformerTestCase
{
    protected static function getTransformer(): ObjectTransformerInterface
    {
        return new MusicAlbumObjectTransformer();
    }

    protected static function getObjectClass(): string
    {
        return MusicAlbumObject::class;
    }

    public static function supportsProvider(): array
    {
        return [
            'true-supports' => [
                'content' => <<<HTML
                        <meta property="og:type" content="music.album"> />
                    HTML,
                'expected' => true,
            ],
            'false-supports' => [
                'content' => '',
                'expected' => false,
            ],
        ];
    }

    public static function shouldThrowExceptionDuringTransformToObjectProvider(): array
    {
        return [
            'with-empty-url' => [
                'content' => <<<HTML
                        <meta property="og:url" content="" />
                        <meta property="og:title" content="Krasilnikovs Homepage" />
                        <meta property="og:image" content="https://krasilnikovs.lv/static/me.webp" />
                    HTML,
                'exceptionClass' => PropertyNotExtractedException::class,
                'exceptionMessage' => 'Required not empty value for property "og:url"',
            ],
            'with-empty-title' => [
                'content' => <<<HTML
                        <meta property="og:url" content="https://krasilnikovs.lv" />
                        <meta property="og:title" content="" />
                        <meta property="og:image" content="https://krasilnikovs.lv/static/me.webp" />
                    HTML,
                'exceptionClass' => PropertyNotExtractedException::class,
                'exceptionMessage' => 'Required not empty value for property "og:title"',
            ],
            'with-empty-image' => [
                'content' => <<<HTML
                        <meta property="og:url" content="https://krasilnikovs.lv" />
                        <meta property="og:title" content="Krasilnikovs Homepage" />
                        <meta property="og:image" content="" />
                    HTML,
                'exceptionClass' => PropertyNotExtractedException::class,
                'exceptionMessage' => 'At least one element required for property "og:image"',
            ],
        ];
    }
}
