<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Scraper;
use Throwable;
use function array_any;
use function iterator_to_array;

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
    public function supports(Scraper $scraper): bool
    {
        return array_any(
            iterator_to_array($this->transformers),
            static fn(ObjectTransformerInterface $transformer) => $transformer->supports($scraper)
        );
    }

    public function toObject(Scraper $scraper): AbstractObject
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($scraper)) {
                try {
                    return $transformer->toObject($scraper);
                } catch (Throwable $exception) {
                    throw TransformationException::notTransformedToObject($exception);
                }
            }
        }

        throw TransformationException::notFoundSupportedTransformerForType(
            $scraper->getContentByName(Scraper::TYPE_PROPERTY)
        );
    }
}
