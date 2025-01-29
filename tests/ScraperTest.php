<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests;

use Krasilnikovs\Opengraph\OpengraphScraper;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(OpengraphScraper::class)]
final class ScraperTest extends TestCase
{
    #[DataProvider('getContentByNameProvider')]
    public function testShouldGetContentByName(string $content, string $propertyName, string $expected): void
    {
        $scraper = OpengraphScraper::fromString($content);

        $actual = $scraper->getContentByName($propertyName);

        self::assertEquals($expected, $actual);
    }


    /**
     * @param string[] $expected
     */
    #[DataProvider('getContentsByNameProvider')]
    public function testShouldGetContentsByName(string $content, string $propertyName, iterable $expected): void
    {
        $scraper = OpengraphScraper::fromString($content);

        $actual = iterator_to_array($scraper->getContentsByName($propertyName));

        self::assertEquals($expected, $actual);
    }

    /**
     * @param array<string, string> $expected
     */
    #[DataProvider('getContentsByPrefixProvider')]
    public function testShouldGetContentsByPrefix(string $content, string $propertyName, array $expected): void
    {
        $scraper = OpengraphScraper::fromString($content);

        $actual = $scraper->getContentsByPrefix($propertyName);

        $actual = iterator_to_array($actual);

        self::assertCount(count($expected), $actual);

        foreach ($actual as [$name, $value]) {
            self::assertArrayHasKey($name, $expected);
            self::assertEquals($expected[$name], $value);
        }
    }

    /**
     * @return array{
     *     exists: array{
     *         content: string,
     *         propertyName: string,
     *         expected: string,
     *     },
     *     not-exists: array{
     *         content: string,
     *         propertyName: string,
     *         expected: string,
     *     },
     * }
     */
    public static function getContentByNameProvider(): array
    {
        $content = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta property="custom:label" content="en_US"/>
                </head>
            </html>
            HTML;

        return [
            'exists' => [
                'content' => $content,
                'propertyName' => 'custom:label',
                'expected' => 'en_US',
            ],
            'not-exists' => [
                'content' => $content,
                'propertyName' => 'custom:number',
                'expected' => '',
            ],
        ];
    }

    /**
     * @return array{
     *     exists: array{
     *         content: string,
     *         propertyName: string,
     *         expected: string[],
     *     },
     *     not-exists: array{
     *         content: string,
     *         propertyName: string,
     *         expected: string[],
     *     },
     * }
     */
    public static function getContentsByNameProvider(): array
    {
        $content = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta property="custom:label" content="en_US"/>
                    <meta property="custom:label" content="ru"/>
                </head>
            </html>
            HTML;

        return [
            'exists' => [
                'content' => $content,
                'propertyName' => 'custom:label',
                'expected' => ['en_US', 'ru'],
            ],
            'not-exists' => [
                'content' => $content,
                'propertyName' => 'custom:number',
                'expected' => [],
            ],
        ];
    }

    /**
     * @return array{
     *     exists: array{
     *         content: string,
     *         propertyName: string,
     *         expected: array<string, string>,
     *     },
     *     not-exists: array{
     *         content: string,
     *         propertyName: string,
     *         expected: array<string, string>,
     *     },
     * }
     */
    public static function getContentsByPrefixProvider(): array
    {
        $content = <<<HTML
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta property="custom:image" content="https://amazon.com/books/ddd.jpg"/>
                    <meta property="custom:image:title" content="DDD in action"/>
                </head>
            </html>
            HTML;

        return [
            'exists' => [
                'content' => $content,
                'propertyName' => 'custom:image',
                'expected' => [
                    'custom:image' => 'https://amazon.com/books/ddd.jpg',
                    'custom:image:title' => 'DDD in action',
                ],
            ],
            'not-exists' => [
                'content' => $content,
                'propertyName' => 'custom:number',
                'expected' => [],
            ],
        ];
    }
}
