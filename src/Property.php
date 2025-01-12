<?php

declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

enum Property: string
{
    case Title = 'og:title';
    case Type = 'og:type';
    case Image = 'og:image';
    case Url = 'og:url';
}
