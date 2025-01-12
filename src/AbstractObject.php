<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Krasilnikovs\Opengraph\Property\Images;
use Krasilnikovs\Opengraph\Property\Title;
use Krasilnikovs\Opengraph\Property\Type;
use Krasilnikovs\Opengraph\Property\Url;

abstract readonly class AbstractObject
{
    public Type $type;
    public Url $url;
    public Title $title;
    public Images $images;

    public function __construct(Url $url, Title $title, Images $images)
    {
        $this->type = $this->getType();
        $this->url  = $url;
        $this->title = $title;
        $this->images = $images;
    }

    abstract protected function getType(): Type;
}
