<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

enum Determiner: string
{
    case A = 'a';
    case An = 'an';
    case The = 'the';
    case Empty = '';
    case Auto = 'auto';
}
