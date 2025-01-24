<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\VideoCollection;

final readonly class MusicPlaylistObject extends AbstractObject
{
    /**
     * @var list<string>
     */
    public array $creators;

    /**
     * @var list<string>
     */
    public array $songs;

    /**
     * @param list<string> $creators
     * @param list<string> $songs
     */
    public function __construct(
        string $url,
        string $title,
        string $description,
        string $siteName,
        Determiner $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
        array $creators,
        array $songs,
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
