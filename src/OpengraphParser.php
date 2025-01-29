<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Transformer\ChainObjectTransformer;
use Krasilnikovs\Opengraph\Transformer\ObjectTransformerInterface;
use Krasilnikovs\Opengraph\Transformer\TransformationException;
use Krasilnikovs\Opengraph\Transformer\WebsiteObjectTransformer;

final readonly class OpengraphParser implements OpengraphParserInterface
{
    private ObjectTransformerInterface $transformer;
    private ObjectTransformerInterface $fallback;

    public function __construct(
        ObjectTransformerInterface $transformer = new ChainObjectTransformer(),
        ObjectTransformerInterface $fallback    = new WebsiteObjectTransformer(),
    )
    {
        $this->transformer = $transformer;
        $this->fallback    = $fallback;
    }

    /**
     * @throws TransformationException
     */
    public function parse(string $content): AbstractObject
    {
        $scraper = OpengraphScraper::fromString($content);

        if (! $this->transformer->supports($scraper)) {
            return $this->fallback->toObject($scraper);
        }

        return $this->transformer->toObject($scraper);
    }
}
