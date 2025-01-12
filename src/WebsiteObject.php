<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Krasilnikovs\Opengraph\Property\Images;
use Krasilnikovs\Opengraph\Property\Title;
use Krasilnikovs\Opengraph\Property\Type;
use Krasilnikovs\Opengraph\Property\Url;

final readonly class WebsiteObject extends AbstractObject
{

    public function __construct(Url $url, Title $title, Images $images)
    {
        parent::__construct($url, $title, $images);
    }

    protected function getType(): Type
    {
        return Type::website();
    }
}
