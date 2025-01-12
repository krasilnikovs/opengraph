<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Transformer;

use Krasilnikovs\Opengraph\Extractor\MetaExtractorInterface;
use Krasilnikovs\Opengraph\Object\AbstractObject;

interface ObjectTransformerInterface
{
    public function supports(MetaExtractorInterface $extractor): bool;
    public function toObject(MetaExtractorInterface $extractor): AbstractObject;
}
