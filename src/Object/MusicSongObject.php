<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Property\VideoCollection;

final readonly class MusicSongObject extends AbstractObject
{
    public int           $duration;
    public Url           $album;
    public UrlCollection $musicians;

    public function __construct(
        Url             $url,
        string          $title,
        string          $description,
        string          $siteName,
        Determiner      $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
        int             $duration,
        Url             $album,
        UrlCollection   $musicians,
    ) {
        $this->duration  = $duration;
        $this->album     = $album;
        $this->musicians = $musicians;

        parent::__construct($url, $title, $description, $siteName, $determiner, $images, $audios, $videos);
    }

    public static function getType(): string
    {
        return 'music.song';
    }
}
