<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Krasilnikovs\Opengraph\Builder\ObjectTransformerInterface;
use Krasilnikovs\Opengraph\Extractor\MetaExtractor;

final readonly class OpengraphParser
{
    private ObjectTransformerInterface $transformer;

    public function __construct(ObjectTransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    public function parse(string $content): AbstractObject
    {
        $extractor = MetaExtractor::fromString($content);

        return $this->transformer->toObject($extractor);
    }
}
