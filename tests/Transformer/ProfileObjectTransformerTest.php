<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyNotExtractedException;
use Krasilnikovs\Opengraph\Object\ProfileObject;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use Krasilnikovs\Opengraph\Transformer\ProfileObjectTransformer;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ProfileObjectTransformer::class)]
final class ProfileObjectTransformerTest extends ObjectTransformerTestCase
{
    protected static function getTransformer(): ObjectTransformerInterface
    {
        return new ProfileObjectTransformer();
    }

    protected static function getObjectClass(): string
    {
        return ProfileObject::class;
    }

    public static function supportsProvider(): array
    {
        return [
            'true-supports' => [
                'content' => <<<HTML
                        <meta property="og:type" content="profile"> />
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
