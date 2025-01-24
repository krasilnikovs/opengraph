<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Property\Extractor\WebsitePropertyExtractor as DefaultExtractor;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Krasilnikovs\Opengraph\Transformer\Exception\TransformationException;
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
    public function supports(MetaScraperInterface $scraper): bool
    {
        return array_any(
            iterator_to_array($this->transformers),
            static fn(ObjectTransformerInterface $transformer) => $transformer->supports($scraper)
        );
    }

    public function toObject(MetaScraperInterface $scraper): AbstractObject
    {
        foreach ($this->transformers as $transformer) {
            if ($transformer->supports($scraper)) {
                try {
                    return $transformer->toObject($scraper);
                } catch (Throwable $exception) {
                    throw TransformationException::transformationError($exception);
                }
            }
        }

        $extractor = DefaultExtractor::fromMetaScraper($scraper);

        throw TransformationException::notFoundSupportedTransformerForType($extractor->type());
    }
}
