<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;
use Krasilnikovs\Opengraph\Transformer\Exception\TransformationException;

interface ObjectTransformerInterface
{
    public function supports(MetaScraperInterface $scraper): bool;

    /**
     * @throws TransformationException
     */
    public function toObject(MetaScraperInterface $scraper): AbstractObject;
}
