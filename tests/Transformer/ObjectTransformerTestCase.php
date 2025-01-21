<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Property\Type;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
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
    final public function testSupports(string $type, bool $expected): void
    {
        $scraper = self::createMock(MetaScraperInterface::class);

        $scraper
            ->expects(self::once())
            ->method('getContentByName')
            ->with(MetaScraperInterface::TYPE_PROPERTY)
            ->willReturn($type)
        ;

        self::assertEquals($expected, $this->transformer->supports($scraper));
    }

    final public function testToObject(): void
    {
        $object = $this->transformer->toObject(
            static::getScraper()
        );

        self::assertInstanceOf(static::getObjectClass(), $object);
    }

    /**
     * @return array{
     *     true-supports: array{
     *         type: string,
     *         expected: bool,
     *     },
     *     false-supports: array{
     *          type: string,
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
                'type' => random_bytes(128),
                'expected' => false,
            ],
        ];
    }

    abstract public static function getTypeProperty(): string;
    abstract protected static function getTransformer(): ObjectTransformerInterface;

    /**
     * @return class-string
     */
    abstract protected static function getObjectClass(): string;
    abstract protected static function getScraper(): MetaScraperInterface;
}
