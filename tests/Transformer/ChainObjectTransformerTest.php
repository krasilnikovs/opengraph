<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Transformer\ChainObjectTransformer;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ChainObjectTransformer::class)]
final class ChainObjectTransformerTest extends ObjectTransformerTestCase
{
    protected static function getTransformer(): ObjectTransformerInterface
    {
        return new ChainObjectTransformer();
    }

    protected static function getObjectClass(): string
    {
        return WebsiteObject::class;
    }

    public static function supportsProvider(): array
    {
        return [
            'true-supports' => [
                'content' => <<<HTML
                        <meta property="og:type" content="website"> />
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
            'no-handler' => [
                'content' => '<meta property="og:type" content="custom-website">',
                'exceptionMessage' => 'Not found transformer for type "custom-website"',
            ],
        ];
    }

}
