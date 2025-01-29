<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Krasilnikovs\Opengraph\Object\AbstractObject;
use Krasilnikovs\Opengraph\Transformer\TransformationException;

interface OpengraphParserInterface
{
    /**
     * @throws TransformationException
     */
    public function parse(string $content): AbstractObject;
}
