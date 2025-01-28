<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\OpengraphScraper;

interface ObjectTransformerInterface
{
    public function supports(OpengraphScraper $scraper): bool;

    /**
     * @throws TransformationException
     */
    public function toObject(OpengraphScraper $scraper): AbstractObject;
}
