<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property\Builder;

use Krasilnikovs\Opengraph\Property\AudioProperty;
use Krasilnikovs\Opengraph\Property\AudioPropertyCollection;
use Krasilnikovs\Opengraph\Property\AudioSecureUrlProperty;
use Krasilnikovs\Opengraph\Property\AudioTypeProperty;

final class AudioPropertyCollectionBuilder
{
    /**
     * @var array<int, array{
     *     url: string,
     *      secureUrl: string,
     *      type: string
     * }>
     */
    private array $elements;

    /**
     * @param array<int, array{
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

    public function withUrl(string $url): self
    {
        $elements = $this->elements;

        $elements[] = [];

        $elements[array_key_last($elements)]['url'] = $url;

        return new self($elements);
    }

    public function withSecureUrl(string $secureUrl): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['secureUrl'] = $secureUrl;

        return new self($elements);
    }

    public function withType(string $type): self
    {
        $elements = $this->elements;
        $key = array_key_last($elements);

        if ($key === null) {
            $elements[] = [];
        }

        $elements[array_key_last($elements)]['type'] = $type;

        return new self($elements);
    }

    public function build(): AudioPropertyCollection
    {
        $audios = array_map(
            static fn(array $element): AudioProperty => AudioProperty::new(
                content: $element['url'] ?? '',
                secureUrl: AudioSecureUrlProperty::fromString($element['secureUrl'] ?? ''),
                type: AudioTypeProperty::fromString($element['type'] ?? ''),
            ),
            $this->elements,
        );

        return new AudioPropertyCollection($audios);
    }
}
