<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\PropertyExtractorInterface;
use Krasilnikovs\Opengraph\Object\AbstractBaseObject;

interface ObjectTransformerInterface
{
    public function supports(PropertyExtractorInterface $extractor): bool;
    public function toObject(PropertyExtractorInterface $extractor): AbstractBaseObject;
}
