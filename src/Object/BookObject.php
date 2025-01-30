<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use DateTimeImmutable;
use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\TagCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\VideoCollection;

/**
 * @link https://ogp.me/#type_book
 */
final readonly class BookObject extends AbstractObject
{
    public string $isbn;
    public string $author;
    public ?DateTimeImmutable $releaseDate;
    public TagCollection $tags;

    public function __construct(
        Url $url,
        string $title,
        string $description,
        string $siteName,
        Determiner $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
        string $isbn,
        string $author,
        ?DateTimeImmutable $releaseDate,
        TagCollection $tags,
    ) {
        $this->isbn = $isbn;
        $this->author = $author;
        $this->releaseDate = $releaseDate;
        $this->tags = $tags;

        parent::__construct($url, $title, $description, $siteName, $determiner, $images, $audios, $videos);
    }

    public static function getType(): string
    {
        return 'book';
    }
}
