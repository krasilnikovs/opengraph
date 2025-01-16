<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractorInterface;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class ObjectTransformerTestCase extends TestCase
{
    private ObjectTransformerInterface $transformer;

    final protected function setUp(): void
    {
        $this->transformer = $this->getTransformer();
    }

    #[DataProvider('supportsProvider')]
    final public function testSupports(TypeProperty $type, bool $expected): void
    {
        $typeExtractor = self::createStub(PropertyExtractorInterface::class);
        $typeExtractor
            ->method('type')
            ->willReturn($type)
        ;

        self::assertEquals($expected, $this->transformer->supports($typeExtractor));
    }

    final public function testToObject(): void
    {
        $object = $this->transformer->toObject(
            static::getExtractor()
        );

        self::assertInstanceOf(static::getObjectClass(), $object);
    }

    /**
     * @return array{
     *     true-supports: array{
     *         type: TypeProperty,
     *         expected: bool,
     *     },
     *     false-supports: array{
     *          type: TypeProperty,
     *          expected: bool,
     *     },
     * }
     */
    final public static function supportsProvider(): array
    {
        return [
            'true-supports' => [
                'type' => static::getTypeProperty(),
                'expected' => true,
            ],
            'false-supports' => [
                'type' => TypeProperty::fromString(random_bytes(128)),
                'expected' => false,
            ],
        ];
    }

    abstract public static function getTypeProperty(): TypeProperty;
    abstract protected static function getTransformer(): ObjectTransformerInterface;

    /**
     * @return class-string
     */
    abstract protected static function getObjectClass(): string;
    abstract protected static function getExtractor(): PropertyExtractorInterface;
}
