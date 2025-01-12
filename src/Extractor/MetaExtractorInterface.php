<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Extractor;

use Krasilnikovs\Opengraph\Property\ImageProperty;

interface MetaExtractorInterface
{
    public function type(): string;
    public function url(): string;
    public function title(): string;

    /**
     * @return array<int, ImageProperty>
     */
    public function images(): array;
}
