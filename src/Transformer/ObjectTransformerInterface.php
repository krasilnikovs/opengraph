<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractorInterface;
use Krasilnikovs\Opengraph\Object\AbstractObject;

interface ObjectTransformerInterface
{
    public function supports(PropertyExtractorInterface $extractor): bool;
    public function toObject(PropertyExtractorInterface $extractor): AbstractObject;
}
