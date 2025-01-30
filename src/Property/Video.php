<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Video
{
    public Url $url;
    public Url $secureUrl;
    public string $type;
    public string $width;
    public string $height;

    private function __construct(
        Url $url,
        Url $secureUrl,
        string $type,
        string $width,
        string $height,
    ) {
        $this->url = $url;
        $this->secureUrl = $secureUrl;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
    }

    public static function new(
        Url $url,
        Url $secureUrl,
        string $type,
        string $width,
        string $height,
    ): self
    {
        return new self($url, $secureUrl, $type, $width, $height);
    }

    /**
     * @param array{
     *     url?:       string,
     *     secureUrl?: string,
     *     type?:      string,
     *     width?:     string,
     *     height?:    string,
     * } $map
     */
    public static function fromArray(array $map): self
    {
        return self::new(
            url:       Url::fromString($map['url'] ?? ''),
            secureUrl: Url::fromString($map['secureUrl'] ?? ''),
            type:      $map['type'] ?? '',
            width:     $map['width'] ?? '',
            height:    $map['height'] ?? '',
        );
    }
}
