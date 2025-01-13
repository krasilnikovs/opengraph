<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractorInterface;
use Krasilnikovs\Opengraph\Model\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Model\Property\TitleProperty;
use Krasilnikovs\Opengraph\Model\Property\TypeProperty;
use Krasilnikovs\Opengraph\Model\Property\UrlProperty;
use Krasilnikovs\Opengraph\Object\WebsiteObject;
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

        self::assertFalse($transformer->supports($this->getExtractor()));
        $transformer->toObject($this->getExtractor());
    }
    public static function getTypeProperty(): TypeProperty
    {
        return TypeProperty::website();
    }

    protected static function getTransformer(): ObjectTransformerInterface
    {
        return new ChainObjectTransformer();
    }

    protected static function getObjectClass(): string
    {
        return WebsiteObject::class;
    }

    protected static function getExtractor(): PropertyExtractorInterface
    {
        return new class implements PropertyExtractorInterface {
            public function type(): TypeProperty
            {
                return TypeProperty::website();
            }

            public function url(): UrlProperty
            {
                return UrlProperty::fromString('https://krasilnikovs.lv');
            }

            public function title(): TitleProperty
            {
                return TitleProperty::fromString('Krasilnikovs Homepage');
            }

            public function images(): ImagePropertyCollection
            {
                return new ImagePropertyCollection([]);
            }
        };
    }

}
