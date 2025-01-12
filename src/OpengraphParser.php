<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Krasilnikovs\Opengraph\Extractor\MetaExtractor;
use Krasilnikovs\Opengraph\Extractor\PropertyExtractor;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use Krasilnikovs\Opengraph\Transformer\WebsiteObjectTransformer;

final readonly class OpengraphParser
{
    private ObjectTransformerInterface $transformer;
    private WebsiteObjectTransformer $fallback;

    public function __construct(ObjectTransformerInterface $transformer)
    {
        $this->transformer = $transformer;
        $this->fallback    = new WebsiteObjectTransformer();
    }

    public function parse(string $content): AbstractObject
    {
        $extractor = PropertyExtractor::fromString($content);

        if (! $this->transformer->supports($extractor)) {
            return $this->fallback->toObject($extractor);
        }

        return $this->transformer->toObject($extractor);
    }
}
