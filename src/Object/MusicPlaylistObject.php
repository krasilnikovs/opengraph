<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Property\VideoCollection;

final readonly class MusicPlaylistObject extends AbstractObject
{
    public UrlCollection $creators;
    public UrlCollection $songs;

    public function __construct(
        Url $url,
        string $title,
        string $description,
        string $siteName,
        Determiner $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
        UrlCollection $creators,
        UrlCollection $songs,
    ) {
        $this->creators = $creators;
        $this->songs = $songs;

        parent::__construct($url, $title, $description, $siteName, $determiner, $images, $audios, $videos);
    }

    public static function getType(): string
    {
        return 'music.playlist';
    }
}
