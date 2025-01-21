<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Image
{
    public string $url;
    public string $secureUrl;
    public string $type;
    public string $width;
    public string $height;
    public string $alt;

    private function __construct(
        string $url,
        string $secureUrl,
        string $type,
        string $width,
        string $height,
        string $alt
    ) {
        $this->url = $url;
        $this->secureUrl = $secureUrl;
        $this->type = $type;
        $this->width = $width;
        $this->height = $height;
        $this->alt = $alt;
    }

    public static function new(
        string $url,
        string $secureUrl,
        string $type,
        string $width,
        string $height,
        string $alt
    ): self
    {
        return new self($url, $secureUrl, $type, $width, $height, $alt);
    }

    /**
     * @param array{
     *     url?:       string,
     *     secureUrl?: string,
     *     type?:      string,
     *     width?:     string,
     *     height?:    string,
     *     alt?:       string
     * } $map
     */
    public static function fromArray(array $map): self
    {
        return self::new(
            url:       $map['url'] ?? '',
            secureUrl: $map['secureUrl'] ?? '',
            type:      $map['type'] ?? '',
            width:     $map['width'] ?? '',
            height:    $map['height'] ?? '',
            alt:       $map['alt'] ?? '',
        );
    }
}
