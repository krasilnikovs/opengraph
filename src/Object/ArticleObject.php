<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\TagCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\VideoCollection;

final readonly class ArticleObject extends AbstractObject
{
    public TagCollection $tags;
    public string $author;
    public string $section;

    public function __construct(
        Url $url,
        string $title,
        string $description,
        string $siteName,
        Determiner $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
        TagCollection $tags,
        string $author,
        string $section,
    ) {
        $this->tags = $tags;
        $this->author = $author;
        $this->section = $section;

        parent::__construct($url, $title, $description, $siteName, $determiner, $images, $audios, $videos);
    }


    public static function getType(): string
    {
        return 'article';
    }
}
