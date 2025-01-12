<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Scraper\MetaScraperInterface;

interface ObjectTransformerInterface
{
    public function supports(MetaScraperInterface $scraper): bool;
    public function toObject(MetaScraperInterface $scraper): AbstractObject;
}
