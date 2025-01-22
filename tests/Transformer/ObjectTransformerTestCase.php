<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Scraper\MetaScraper;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Krasilnikovs\Opengraph\Transformer\Exception\TransformationException;
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
    final public function testSupports(string $content, bool $expected): void
    {
        $scraper = MetaScraper::fromString($content);

        self::assertEquals($expected, $this->transformer->supports($scraper));
    }

    final public function testShouldTransformToObject(): void
    {
        $object = $this->transformer->toObject(
            self::getScraper()
        );

        self::assertInstanceOf(static::getObjectClass(), $object);
    }

    #[DataProvider('shouldThrowExceptionDuringTransformToObjectProvider')]
    final public function testShouldThrowExceptionDuringTransformToObject(
        string $content,
        string $exceptionMessage,
    ): void
    {
        $this->expectException(TransformationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $this->transformer->toObject(
            MetaScraper::fromString($content)
        );
    }

    /**
     * @return array<string, array{
     *     content: string,
     *     expected: bool
     * }>
     */
    abstract public static function supportsProvider(): array;

    /**
     * @return array<string, array{
     *     content: string,
     *     exceptionMessage: string,
     * }>
     */
    abstract public static function shouldThrowExceptionDuringTransformToObjectProvider(): array;

    abstract protected static function getTransformer(): ObjectTransformerInterface;

    /**
     * @return class-string
     */
    abstract protected static function getObjectClass(): string;
    final protected static function getScraper(): MetaScraperInterface
    {
        return new class implements MetaScraperInterface {
            public function getContentByName(string $name): string
            {
                return match ($name) {
                    MetaScraperInterface::TYPE_PROPERTY => 'website',
                    MetaScraperInterface::URL_PROPERTY => 'https://krasilnikovs.lv',
                    MetaScraperInterface::TITLE_PROPERTY => 'Krasilnikovs Homepage',
                    MetaScraperInterface::DESCRIPTION_PROPERTY => 'Krasilnikovs Homepage',
                    MetaScraperInterface::DETERMINER_PROPERTY => 'auto',
                    MetaScraperInterface::LOCALE_PROPERTY => 'lv',
                    default => '',
                };
            }

            public function getContentsByName(string $name): iterable
            {
                return match ($name) {
                    MetaScraperInterface::LOCALE_ALTERNATE_PROPERTY => ['ru'],
                    default => [],
                };
            }

            public function getContentsByPrefix(string $prefix): iterable
            {
                if (str_contains($prefix, self::IMAGE_PROPERTY)) {
                    yield [MetaScraperInterface::IMAGE_PROPERTY, 'https://krasilnikovs.lv/static/me.webp'];
                }
            }
        };
    }
}
