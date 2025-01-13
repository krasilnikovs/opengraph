<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Model\Property;

use ArrayAccess;
use Iterator;

/**
 * @template-implements Iterator<array-key, ImageProperty>
 * @template-implements ArrayAccess<array-key, ImageProperty>
 */
final class ImagePropertyCollection implements Iterator, ArrayAccess
{
    /**
     * @var array<array-key, ImageProperty>
     */
    private array $images;
    private int $index;

    /**
     * @param array<int, ImageProperty> $images
     */
    public function __construct(array $images = [])
    {
        $this->images = $images;
        $this->index = count($this->images) - 1;
    }

    /**
     * @param array<int, ImageProperty> $images
     * @return self
     */
    public static function fromArray(array $images): self
    {
        return new self($images);
    }

    public function current(): ImageProperty
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

    public function offsetGet(mixed $offset): ?ImageProperty
    {
        return $this->images[$offset];
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
