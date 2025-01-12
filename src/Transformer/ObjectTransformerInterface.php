<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Builder;

use Krasilnikovs\Opengraph\AbstractObject;
use Krasilnikovs\Opengraph\Extractor\MetaExtractor;

interface ObjectTransformerInterface
{
    public function supports(MetaExtractor $extractor): bool;
    public function toObject(MetaExtractor $extractor): AbstractObject;
}
