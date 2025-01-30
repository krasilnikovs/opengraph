<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\UrlCollection;
use Krasilnikovs\Opengraph\Property\VideoCollection;

/**
 * @link https://ogp.me/#type_music.album
 */
final readonly class MusicAlbumObject extends AbstractObject
{
    public ?DateTimeImmutable $releaseDate;
    public UrlCollection      $musicians;
    public UrlCollection      $songs;

    public function __construct(
        Url                $url,
        string             $title,
        string             $description,
        string             $siteName,
        Determiner         $determiner,
        ImageCollection    $images,
        AudioCollection    $audios,
        VideoCollection    $videos,
        ?DateTimeImmutable $releaseDate,
        UrlCollection      $musicians,
        UrlCollection      $songs,
    ) {
        $this->releaseDate = $releaseDate;
        $this->musicians   = $musicians;
        $this->songs       = $songs;

        parent::__construct($url, $title, $description, $siteName, $determiner, $images, $audios, $videos);
    }

    public static function getType(): string
    {
        return 'music.album';
    }
}
