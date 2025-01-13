<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractorInterface;
use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Property\ImagePropertyCollection;
use Krasilnikovs\Opengraph\Property\TitleProperty;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Property\UrlProperty;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use Krasilnikovs\Opengraph\Transformer\WebsiteObjectTransformer;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(WebsiteObjectTransformer::class)]
final class WebsiteObjectTransformerTest extends ObjectTransformerTestCase
{
    public static function getTypeProperty(): TypeProperty
    {
        return TypeProperty::website();
    }

    protected static function getTransformer(): ObjectTransformerInterface
    {
        return new WebsiteObjectTransformer();
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
