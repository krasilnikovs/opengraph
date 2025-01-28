<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph;

use Dom\HTMLDocument;
use function current;
use function iterator_to_array;
use function sprintf;

final readonly class OpengraphScraper
{
    public const string TYPE_PROPERTY = 'og:type';
    public const string URL_PROPERTY = 'og:url';
    public const string TITLE_PROPERTY = 'og:title';
    public const string DESCRIPTION_PROPERTY = 'og:description';
    public const string DETERMINER_PROPERTY = 'og:determiner';
    public const string SITE_NAME_PROPERTY = 'og:site_name';

    public const string LOCALE_PROPERTY = 'og:locale';
    public const string LOCALE_ALTERNATE_PROPERTY = 'og:locale:alternate';

    public const string IMAGE_PROPERTY = 'og:image';
    public const string IMAGE_SECURE_URL_PROPERTY = 'og:image:secure_url';
    public const string IMAGE_TYPE_PROPERTY = 'og:image:type';
    public const string IMAGE_WIDTH_PROPERTY = 'og:image:width';
    public const string IMAGE_HEIGHT_PROPERTY = 'og:image:height';
    public const string IMAGE_ALT_PROPERTY = 'og:image:alt';

    public const string AUDIO_PROPERTY = 'og:audio';
    public const string AUDIO_SECURE_URL_PROPERTY = 'og:audio:secure_url';
    public const string AUDIO_TYPE_PROPERTY = 'og:audio:type';

    public const string VIDEO_PROPERTY = 'og:video';
    public const string VIDEO_SECURE_URL_PROPERTY = 'og:video:secure_url';
    public const string VIDEO_TYPE_PROPERTY = 'og:video:type';
    public const string VIDEO_WIDTH_PROPERTY = 'og:video:width';
    public const string VIDEO_HEIGHT_PROPERTY = 'og:video:height';

    public const string MUSIC_RELEASE_DATE_PROPERTY = 'music:release_date';
    public const string MUSIC_MUSICIAN_PROPERTY = 'music:musician';
    public const string MUSIC_SONG_PROPERTY = 'music:song';
    public const string MUSIC_DURATION_PROPERTY = 'music:duration';
    public const string MUSIC_ALBUM_PROPERTY = 'music:album';
    public const string MUSIC_CREATOR_PROPERTY = 'music:creator';

    private HTMLDocument $document;

    public function __construct(string $content)
    {
        $this->document = @HTMLDocument::createFromString($content);
    }

    public static function fromString(string $content): self
    {
        return new self($content);
    }

    public function getContentByName(string $name): string
    {
        $properties = $this->getContentsByName($name);

        return (string) current(iterator_to_array($properties));
    }

    /**
     * @return iterable<string>
     */
    public function getContentsByName(string $name): iterable
    {
        $query = sprintf('meta[property="%s"]', $name);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield (string) $element->getAttribute('content');
        }
    }

    /**
     * @return iterable<array{string, string}>
     */
    public function getContentsByPrefix(string $prefix): iterable
    {
        $query = sprintf('meta[property^="%s"]', $prefix);
        $elements = $this->document->querySelectorAll($query);

        foreach ($elements as $element) {
            yield [(string) $element->getAttribute('property'), (string) $element->getAttribute('content')];
        }
    }
}
