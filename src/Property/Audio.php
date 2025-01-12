<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

final readonly class Audio
{
    public string $url;
    public string $secureUrl;
    public string $type;

    private function __construct(string $url, string $secureUrl, string $type)
    {
        $this->url = $url;
        $this->secureUrl = $secureUrl;
        $this->type = $type;
    }

    public static function new(string $url, string $secureUrl, string $type): self
    {
        return new self(
            $url,
            $secureUrl,
            $type
        );
    }

    /**
     * @param array{
     *     url?:       string,
     *     secureUrl?: string,
     *     type?:      string
     * } $map
     */
    public static function fromArray(array $map): self
    {
        return self::new(
            url:       $map['url'] ?? '',
            secureUrl: $map['secureUrl'] ?? '',
            type:      $map['type'] ?? '',
        );
    }
}
