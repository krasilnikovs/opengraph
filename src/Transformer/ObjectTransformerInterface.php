<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Scraper;
use Krasilnikovs\Opengraph\Transformer\Exception\TransformationException;

interface ObjectTransformerInterface
{
    public function supports(Scraper $scraper): bool;

    /**
     * @throws TransformationException
     */
    public function toObject(Scraper $scraper): AbstractObject;
}
