<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MetaExtractorInterface;
use Krasilnikovs\Opengraph\Object\AbstractObject;
use LogicException;
use function array_any;
use function iterator_to_array;
use function sprintf;

final readonly class ChainObjectTransformer implements ObjectTransformerInterface
{
    /**
     * @var ObjectTransformerInterface[]
     */
    private iterable $transformers;

    /**
     * @param ObjectTransformerInterface[] $transformers
     */
    public function __construct(iterable $transformers = [
        new WebsiteObjectTransformer(),
    ]) {
        $this->transformers = $transformers;
    }
    public function supports(MetaExtractorInterface $extractor): bool
    {
        return array_any(
            iterator_to_array($this->transformers),
            static fn(ObjectTransformerInterface $transformer) => $transformer->supports($extractor)
        );
    }

    public function toObject(MetaExtractorInterface $extractor): AbstractObject
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($extractor)) {
                return $transformer->toObject($extractor);
            }
        }

        $this->throwLogicException($extractor);
    }

    private function throwLogicException(MetaExtractorInterface $extractor): never
    {
        throw new LogicException(
            sprintf(
                'No appropriate object transformer for type "%s"',
                $extractor->type(),
            ),
        );
    }
}
