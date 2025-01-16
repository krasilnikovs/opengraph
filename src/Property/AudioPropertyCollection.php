<?php declare(strict_types=1);

namespace Krasilnikovs\Opengraph\Property;

use ArrayAccess;
use Iterator;

/**
 * @template-implements Iterator<array-key, AudioProperty>
 * @template-implements ArrayAccess<array-key, AudioProperty>
 */
final class AudioPropertyCollection implements Iterator, ArrayAccess
{
    /**
     * @var array<array-key, AudioProperty>
     */
    private array $audios;
    private int $index;

    /**
     * @param array<int, AudioProperty> $audios
     */
    public function __construct(array $audios = [])
    {
        $this->audios = $audios;
        $this->index = count($this->audios) - 1;
    }

    /**
     * @param array<int, AudioProperty> $images
     * @return self
     */
    public static function fromArray(array $images): self
    {
        return new self($images);
    }

    public function current(): AudioProperty
    {
        return $this->audios[$this->index];
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
        return isset($this->audios[$this->index]);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->audios[$offset]);
    }

    public function offsetGet(mixed $offset): ?AudioProperty
    {
        return $this->audios[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->audios[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->audios[$offset]);
    }
}
