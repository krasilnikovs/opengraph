<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case Undefined = 'undefined';
}
