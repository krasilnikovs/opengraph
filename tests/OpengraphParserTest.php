<?php declare(strict_types=1);

namespace Krasilnikovs\tests;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\OpengraphParser;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\VideoCollection;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use PHPUnit\Framework\TestCase;

final class OpengraphParserTest extends TestCase
{

    public function testShouldParseUsingFallback(): void
    {
        $transformer = $this->createStub(ObjectTransformerInterface::class);

        $transformer
            ->method('supports')
            ->willReturn(false)
        ;

        $fallbackTransformer = $this->getFallbackTransformer();

        $parser = new OpengraphParser($transformer, $fallbackTransformer);

        $object = $parser->parse('');

        self::assertEquals('fallback-transformer', $object->type);
    }

    public function testShouldParseUsingOriginalTransformer(): void
    {
        $transformer = $this->getTransformer();
        $fallbackTransformer = $this->getFallbackTransformer();

        $parser = new OpengraphParser($transformer, $fallbackTransformer);

        $object = $parser->parse('');

        self::assertEquals('original-transformer', $object->type);
    }

    public function getTransformer(): ObjectTransformerInterface
    {
        return new class implements ObjectTransformerInterface {
            public function supports(MetaScraperInterface $scraper): bool
            {
                return true;
            }

            public function toObject(MetaScraperInterface $scraper): AbstractObject
            {
                return new readonly class extends AbstractObject
                {
                    public function __construct()
                    {
                        parent::__construct(
                            url: 'https://krasilnikovs.lv',
                            title: 'Home Page',
                            description: 'Krasilnikovs Home Page',
                            siteName: 'Krasilnikovs',
                            determiner: Determiner::A,
                            images: new ImageCollection([]),
                            audios: new AudioCollection([]),
                            videos: new VideoCollection([]),
                        );
                    }

                    public static function getType(): string
                    {
                        return 'original-transformer';
                    }
                };
            }
        };
    }

    private function getFallbackTransformer(): ObjectTransformerInterface
    {
        return new class() implements ObjectTransformerInterface {
            public function supports(MetaScraperInterface $scraper): bool
            {
                return true;
            }

            public function toObject(MetaScraperInterface $scraper): AbstractObject
            {
                return new readonly class extends AbstractObject
                {
                    public function __construct()
                    {
                        parent::__construct(
                            url: 'https://krasilnikovs.lv',
                            title: 'Home Page',
                            description: 'Krasilnikovs Home Page',
                            siteName: 'Krasilnikovs',
                            determiner: Determiner::A,
                            images: new ImageCollection([]),
                            audios: new AudioCollection([]),
                            videos: new VideoCollection([]),
                        );
                    }

                    public static function getType(): string
                    {
                        return 'fallback-transformer';
                    }
                };
            }
        };
    }
}
