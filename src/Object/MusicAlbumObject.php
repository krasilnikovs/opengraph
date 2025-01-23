<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\VideoCollection;

final readonly class MusicAlbumObject extends AbstractObject
{
    public ?DateTimeImmutable $releaseDate;

    /**
     * @var array<array-key, string>
     */
    public array $musicians;

    /**
     * @var array<array-key, string>
     */
    public array $songs;

    /**
     * @param list<string> $musicians
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
        ?DateTimeImmutable $releaseDate,
        array $musicians,
        array $songs,
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
