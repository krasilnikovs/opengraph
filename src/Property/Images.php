<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use Iterator;

/**
 * @template-implements Iterator<array-key, Image>
 */
final class Images implements Iterator
{
    /**
     * @var iterable<array-key, Image>
     */
    private iterable $images;
    private int $index;

    public function __construct(iterable $images = [])
    {
        $this->images = $images;
        $this->index = count($this->images) - 1;
    }

    public static function fromIterable(iterable $images): self
    {
        return new self($images);
    }

    public function current(): Image
    {
        return $this->images[$this->index];
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->images[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
