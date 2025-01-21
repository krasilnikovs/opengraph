<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Builder;

use Krasilnikovs\Opengraph\Property\Audio;
use Krasilnikovs\Opengraph\Property\AudioCollection;

final readonly class AudioCollectionBuilder
{
    /**
     * @var array<array-key, array{
     *     url?: string,
     *     secureUrl?: string,
     *     type?: string
     * }>
     */
    private array $elements;

    /**
     * @param array<array-key, array{
     *      url?: string,
     *      secureUrl?: string,
     *      type?: string
     * }> $elements
     */
    private function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public static function new(): self
    {
        return new self([]);
    }

    public function append(): self
    {
        $elements = $this->elements;

        $elements[] = [];

        return new self($elements);
    }

    public function withUrl(string $url): self
    {
        $elements = $this->elements;

        $key = array_key_last($elements);

        if($key === null) {
            return new self($elements);
        }

        $elements[$key]['url'] = $url;

        return new self($elements);
    }

    public function withSecureUrl(string $secureUrl): self
    {
        $elements = $this->elements;

        $key = array_key_last($elements);

        if($key === null) {
            return new self($elements);
        }

        $elements[$key]['secureUrl'] = $secureUrl;

        return new self($elements);
    }

    public function withType(string $type): self
    {
        $elements = $this->elements;

        $key = array_key_last($elements);

        if($key === null) {
            return new self($elements);
        }

        $elements[$key]['type'] = $type;

        return new self($elements);
    }

    public function build(): AudioCollection
    {
        $audios = array_map(Audio::fromArray(...), $this->elements);

        return new AudioCollection($audios);
    }
}
