<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use ArrayAccess;
use Iterator;

/**
 * @template-implements Iterator<array-key, Image>
 * @template-implements ArrayAccess<array-key, Image>
 */
final class ImageCollection implements Iterator, ArrayAccess
{
    /**
     * @var array<array-key, Image>
     */
    private array $images;
    private int $index;

    /**
     * @param array<array-key, Image> $images
     */
    public function __construct(array $images = [])
    {
        $this->images = $images;
        $this->index = count($this->images) - 1;
    }

    /**
     * @param array<int, Image> $images
     * @return self
     */
    public static function fromArray(array $images): self
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

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->images[$offset]);
    }

    public function offsetGet(mixed $offset): ?Image
    {
        return $this->images[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->images[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->images[$offset]);
    }
}
