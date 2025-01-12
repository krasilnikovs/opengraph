<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Tests\Transformer;

use Krasilnikovs\Opengraph\Extractor\MetaExtractorInterface;
use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Property\TypeProperty;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use Krasilnikovs\Opengraph\Transformer\WebsiteObjectTransformer;

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

    protected static function getExtractor(): MetaExtractorInterface
    {
        return new class implements MetaExtractorInterface {
            public function type(): string
            {
                return TypeProperty::website()->value;
            }

            public function url(): string
            {
                return 'https://krasilnikovs.lv';
            }

            public function title(): string
            {
                return 'Krasilnikovs Homepage';
            }

            public function images(): array
            {
                return [];
            }
        };
    }

}
