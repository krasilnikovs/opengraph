<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Krasilnikovs\Opengraph\Transformer\ChainObjectTransformer;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use LogicException;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ChainObjectTransformer::class)]
final class ChainObjectTransformerTest extends ObjectTransformerTestCase
{
    public function testShouldThrowLogicException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('No appropriate object transformer for type "website"');

        $transformer = new ChainObjectTransformer([]);

        self::assertFalse($transformer->supports($this->getScraper()));
        $transformer->toObject($this->getScraper());
    }
    public static function getTypeProperty(): string
    {
        return WebsiteObject::getType();
    }

    protected static function getTransformer(): ObjectTransformerInterface
    {
        return new ChainObjectTransformer();
    }

    protected static function getObjectClass(): string
    {
        return WebsiteObject::class;
    }

    protected static function getScraper(): MetaScraperInterface
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

            public function getContentsByName(string $name): array
            {
                return match ($name) {
                    MetaScraperInterface::LOCALE_ALTERNATE_PROPERTY => ['ru'],
                    default => [],
                };
            }

            public function getContentsByPrefix(string $prefix): iterable
            {
                return match ($prefix) {
                    MetaScraperInterface::IMAGE_PROPERTY => [],
                    MetaScraperInterface::AUDIO_PROPERTY => [],
                    default => [],
                };
            }
        };
    }

}
