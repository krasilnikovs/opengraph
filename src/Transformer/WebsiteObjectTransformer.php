<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Object\WebsiteObject;
use Krasilnikovs\Opengraph\Property\Extractor\PropertyExtractor;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Krasilnikovs\Opengraph\Transformer\Exception\TransformationException;

final readonly class WebsiteObjectTransformer implements ObjectTransformerInterface
{
    public function supports(MetaScraperInterface $scraper): bool
    {
        $extractor = PropertyExtractor::fromMetaScraper($scraper);

        return $extractor->type() === WebsiteObject::getType();
    }

    public function toObject(MetaScraperInterface $scraper): AbstractObject
    {
        $extractor = PropertyExtractor::fromMetaScraper($scraper);

        if ($extractor->url() === '') {
            throw TransformationException::requiredNotEmptyValueForProperty(
                MetaScraperInterface::URL_PROPERTY
            );
        }

        if ($extractor->title() === '') {
            throw TransformationException::requiredNotEmptyValueForProperty(
                MetaScraperInterface::TITLE_PROPERTY
            );
        }

        if ($extractor->images()->count() < 1) {
            throw TransformationException::atLeastOneElementRequiredForProperty(
                MetaScraperInterface::IMAGE_PROPERTY
            );
        }

        return new WebsiteObject(
            url:         $extractor->url(),
            title:       $extractor->title(),
            description: $extractor->description(),
            siteName:    $extractor->siteName(),
            determiner:  $extractor->determiner(),
            images:      $extractor->images(),
            audios:      $extractor->audios(),
            videos:      $extractor->videos(),
        );
    }


}
