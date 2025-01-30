<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Object;

use Krasilnikovs\Opengraph\Property\AudioCollection;
use Krasilnikovs\Opengraph\Property\Determiner;
use Krasilnikovs\Opengraph\Property\ImageCollection;
use Krasilnikovs\Opengraph\Property\Url;
use Krasilnikovs\Opengraph\Property\VideoCollection;

/**
 * @link https://ogp.me/#metadata
 * @link https://ogp.me/#optional
 */
abstract readonly class AbstractObject
{
    public string          $type;
    public Url             $url;
    public string          $title;
    public string          $description;
    public string          $siteName;
    public Determiner      $determiner;
    public ImageCollection $images;
    public AudioCollection $audios;
    public VideoCollection $videos;

    public function __construct(
        Url             $url,
        string          $title,
        string          $description,
        string          $siteName,
        Determiner      $determiner,
        ImageCollection $images,
        AudioCollection $audios,
        VideoCollection $videos,
    ) {
        $this->type = static::getType();
        $this->url  = $url;
        $this->title = $title;
        $this->description = $description;
        $this->siteName = $siteName;
        $this->determiner = $determiner;
        $this->images = $images;
        $this->audios = $audios;
        $this->videos = $videos;
    }

    abstract public static function getType(): string;
}
