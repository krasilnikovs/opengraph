<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Scraper;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Throwable;

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
        $scraper = Scraper::fromString($content);

        self::assertEquals($expected, $this->transformer->supports($scraper));
    }

    final public function testShouldTransformToObject(): void
    {
        $content = <<<HTML
                <meta property="og:type" content="website">
                <meta property="og:url" content="https://krasilnikovs.lv">
                <meta property="og:title" content="Krasilnikovs Homepage">    
                <meta property="og:description" content="Krasilnikovs Homepage">
                <meta property="og:determiner" content="auto">
                <meta property="og:image" content="https://krasilnikovs.lv/static/me.webp">
                <meta property="og:locale" content="lv">
                <meta property="og:locale:alternate" content="ru">
            HTML;

        $object = $this->transformer->toObject(
            Scraper::fromString($content)
        );

        self::assertInstanceOf(static::getObjectClass(), $object);
    }

    /**
     * @param class-string<Throwable> $exceptionClass
     */
    #[DataProvider('shouldThrowExceptionDuringTransformToObjectProvider')]
    final public function testShouldThrowExceptionDuringTransformToObject(
        string $content,
        string $exceptionClass,
        string $exceptionMessage,
    ): void
    {
        $this->expectException($exceptionClass);
        $this->expectExceptionMessage($exceptionMessage);

        $this->transformer->toObject(
            Scraper::fromString($content)
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
     *     exceptionClass: class-string<\Throwable>,
     *     exceptionMessage: string,
     * }>
     */
    abstract public static function shouldThrowExceptionDuringTransformToObjectProvider(): array;

    abstract protected static function getTransformer(): ObjectTransformerInterface;

    /**
     * @return class-string
     */
    abstract protected static function getObjectClass(): string;
}
